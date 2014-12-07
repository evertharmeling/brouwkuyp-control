<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

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
class Procedure implements ExecutableInterface,BatchElementInterface
{
    use ExecutableTrait;
    use BatchElementTrait;

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
        echo 'Procedure::start' . PHP_EOL;

        if (!$this->started) {
            $this->batch->startTimer($this->name, 'start');
            $this->started = true;
            // Start first UnitProcedure
            if ($this->unitProcedures->count()) {
                $this->unitProcedures->first()->start();
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
            $this->finished = true;

            return;
        }

        // Start the next unit procedure?
        if ($this->getCurrentUnitProcedure()->isFinished()) {
            // Go to next unit procedure if possible
            if ($this->unitProcedures->next()) {
                $this->getCurrentUnitProcedure()->start();
            } else {
                // If last unit procedure is finished
                // set the finished flag
                $this->finished = true;
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
     * @return UnitProcedure|false
     */
    public function getCurrentUnitProcedure()
    {
        return $this->getUnitProcedures()->current();
    }
}
