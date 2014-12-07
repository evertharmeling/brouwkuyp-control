<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\BrewEvents;
use Brouwkuyp\Bundle\LogicBundle\Event\EventDispatcherAwareInterface;
use Brouwkuyp\Bundle\LogicBundle\Event\ProcedureFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\ProcedureStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Traits\EventDispatcherTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\ExecutableTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\BatchElementTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Procedure
 *
 * A procedure is the highest-level in the procedural control
 * hierarchy. It defines the overall strategy for making a batch.
 * It consists of an ordered set of unit procedures.
 */
class Procedure implements ExecutableInterface, BatchElementInterface, EventDispatcherAwareInterface
{
    use ExecutableTrait;
    use BatchElementTrait;
    use EventDispatcherTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ControlRecipe
     */
    protected $controlRecipe;

    /**
     * Collection of UnitProcedure
     *
     * @var ArrayCollection
     */
    protected $unitProcedures;

    public function __construct()
    {
        $this->unitProcedures = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param  string    $name
     * @return Procedure
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set ControlRecipe
     *
     * @param  ControlRecipe $controlRecipe
     * @return Procedure
     */
    public function setControlRecipe(ControlRecipe $controlRecipe = null)
    {
        $this->controlRecipe = $controlRecipe;

        return $this;
    }

    /**
     * Get controlrecipe
     *
     * @return ControlRecipe
     */
    public function getControlRecipe()
    {
        return $this->controlRecipe;
    }

    /**
     * Add UnitProcedure
     *
     * @param  UnitProcedure $unitProcedure
     * @return Procedure
     */
    public function addUnitprocedure(UnitProcedure $unitProcedure)
    {
        $this->unitProcedures [] = $unitProcedure;

        return $this;
    }

    /**
     * Remove UnitProcedure
     *
     * @param UnitProcedure $unitProcedure
     */
    public function removeUnitProcedure(UnitProcedure $unitProcedure)
    {
        $this->unitProcedures->removeElement($unitProcedure);
    }

    /**
     * Get UnitProcedure
     *
     * @return ArrayCollection
     */
    public function getUnitProcedures()
    {
        return $this->unitProcedures;
    }

    /**
     * @see ExecutableInterface::start()
     */
    public function start()
    {
        if (!$this->started) {
            $this->batch->startTimer($this->name, 'start');
            $this->setStarted();

            // Start first UnitProcedure
            if ($this->unitProcedures->count()) {
                $unitProcedure = $this->unitProcedures->first();
                $unitProcedure->setEventDispatcher($this->eventDispatcher);
                $unitProcedure->start();
            }
        }
    }

    /**
     * @see ExecutableInterface::execute()
     */
    public function execute()
    {
        if (!$this->isStarted()) {
            throw new \Exception('Procedure not started');
        }

        if (!$this->getCurrentUnitProcedure()) {
            $this->setFinished();

            return;
        }

        // Start the next unit procedure?
        if ($this->getCurrentUnitProcedure()->isFinished()) {
            // Go to next unit procedure if possible
            if ($this->unitProcedures->next()) {
                $this->getCurrentUnitProcedure()->setEventDispatcher($this->eventDispatcher);
                $this->getCurrentUnitProcedure()->start();
            } else {
                // If last unit procedure is finished
                // set the finished flag
                $this->setFinished();
            }
        }
        // Execute
        if (!$this->finished &&
                 $this->getCurrentUnitProcedure()->isStarted()) {
            // Perform unit procedure
            $this->getCurrentUnitProcedure()->execute();
        }
    }

    /**
     * @return Phase
     */
    public function setStarted()
    {
        $this->started = true;
        $this->eventDispatcher->dispatch(BrewEvents::PROCEDURE_START, new ProcedureStartEvent($this));

        return $this;
    }

    /**
     * Function to finish the Phase
     */
    public function setFinished()
    {
        $this->finished = true;
        $this->eventDispatcher->dispatch(BrewEvents::PROCEDURE_FINISH, new ProcedureFinishEvent($this));

        return $this;
    }

    /**
     * @return UnitProcedure|false
     */
    public function getCurrentUnitProcedure()
    {
        return $this->getUnitProcedures()->current();
    }
}
