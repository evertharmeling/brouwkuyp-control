<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\BrewEvents;
use Brouwkuyp\Bundle\LogicBundle\Event\EventDispatcherAwareInterface;
use Brouwkuyp\Bundle\LogicBundle\Event\OperationFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\OperationStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Traits\BatchElementTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\EventDispatcherTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\ExecutableTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Operation
 *
 * An operation is an ordered set of phases carried to completion
 * within a single unit. Operations usually involve taking the
 * material being processed through some type of physical, chemical,
 * or biological change. Like unit procedures, the standard presumes
 * only one operation is active on a particular unit at a time.
 */
class Operation implements ExecutableInterface, BatchElementInterface, EventDispatcherAwareInterface
{
    use ExecutableTrait;
    use BatchElementTrait;
    use EventDispatcherTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection|Phase[]
     */
    protected $phases;

    /**
     * @var UnitProcedure
     */
    protected $unitProcedure;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phases = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param  string    $name
     * @return Operation
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
     * Add phase
     *
     * @param  Phase     $phase
     * @return Operation
     */
    public function addPhase(Phase $phase)
    {
        $this->phases[] = $phase;

        return $this;
    }

    /**
     * Remove phase
     *
     * @param Phase $phase
     */
    public function removePhase(Phase $phase)
    {
        $this->phases->removeElement($phase);
    }

    /**
     * Get phase
     *
     * @return ArrayCollection|Phase[]
     */
    public function getPhases()
    {
        return $this->phases;
    }

    /**
     * Set UnitProcedure
     *
     * @param  UnitProcedure $unitProcedure
     * @return Operation
     */
    public function setUnitProcedure(UnitProcedure $unitProcedure = null)
    {
        $this->unitProcedure = $unitProcedure;

        return $this;
    }

    /**
     * Get UnitProcedure
     *
     * @return UnitProcedure
     */
    public function getUnitProcedure()
    {
        return $this->unitProcedure;
    }

    /**
     * Starts the operation
     */
    public function start()
    {
        if (!$this->started) {
            $this->batch->startTimer($this->name, 'start');
            // Set flag that we are started
            $this->setStarted();

            // Start first UnitProcedure
            if ($this->phases->count()) {
                $phase = $this->phases->first();
                $phase->setEventDispatcher($this->eventDispatcher);
                $phase->start();
            }
        }
    }

    /**
     * Executes stage
     */
    public function execute()
    {
        if (!$this->started) {
            throw new \Exception('Operation not started');
        }

        if (!$this->phases->current()) {
            $this->setFinished();

            return;
        }

        // Start the next phase?
        if ($this->getCurrentPhase()->isFinished()) {
            // Go to next phase if possible
            if ($this->phases->next()) {
                $this->getCurrentPhase()->setEventDispatcher($this->eventDispatcher);
                $this->getCurrentPhase()->start();
            } else {
                // If last phase is finished
                // set the finished flag
                $this->setFinished();
            }
        }
        // Execute
        if (!$this->finished && $this->getCurrentPhase()->isStarted()) {
            // Perform phase
            $this->getCurrentPhase()->execute();
        }
    }

    /**
     * @return Operation
     */
    public function setStarted()
    {
        $this->started = true;
        $this->eventDispatcher->dispatch(BrewEvents::OPERATION_START, new OperationStartEvent($this));

        return $this;
    }

    /**
     * @return Operation
     */
    public function setFinished()
    {
        $this->finished = true;
        $this->eventDispatcher->dispatch(BrewEvents::OPERATION_FINISH, new OperationFinishEvent($this));

        return $this;
    }

    /**
     * @return Phase|false
     */
    public function getCurrentPhase()
    {
        return $this->phases->current();
    }
}
