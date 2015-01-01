<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\BrewEvents;
use Brouwkuyp\Bundle\LogicBundle\Event\EventDispatcherAwareInterface;
use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Unit;
use Brouwkuyp\Bundle\LogicBundle\Traits\BatchElementTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\EventDispatcherTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\ExecutableTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UnitProcedure
 *
 * A unit procedure is an ordered set of operations that is carried
 * to completion on a single unit. That is, a unit procedure is a
 * contiguous production sequence acting on one and only one unit.
 * Only one unit procedure is allowed to be active on a unit at any time.
 * Multiple unit procedures can run concurrently as part of the same
 * procedure, as long as they are active on different units.
 */
class UnitProcedure implements ExecutableInterface, BatchElementInterface, EventDispatcherAwareInterface
{
    use ExecutableTrait;
    use BatchElementTrait;
    use EventDispatcherTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection|Operation[]
     */
    protected $operations;

    /**
     * @var Procedure
     */
    protected $procedure;

    /**
     * @var Unit
     */
    protected $unit;

    /**
     * Constructs
     */
    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param  string        $name
     * @return UnitProcedure
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
     * Add operation
     *
     * @param  Operation     $operation
     * @return UnitProcedure
     */
    public function addOperation(Operation $operation)
    {
        $this->operations[] = $operation;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param Operation $operation
     */
    public function removeOperation(Operation $operation)
    {
        $this->operations->removeElement($operation);
    }

    /**
     * Get operation
     *
     * @return ArrayCollection|Operation[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Set procedure
     *
     * @param  Procedure     $procedure
     * @return UnitProcedure
     */
    public function setProcedure(Procedure $procedure = null)
    {
        $this->procedure = $procedure;

        return $this;
    }

    /**
     * Get procedure
     *
     * @return Procedure
     */
    public function getProcedure()
    {
        return $this->procedure;
    }

    /**
     * Set unit
     *
     * @param  Unit          $unit
     * @return UnitProcedure
     */
    public function setUnit(Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @see ExecutableInterface::start()
     */
    public function start()
    {
        if (!$this->started) {
            $this->batch->startTimer($this->name, 'start');
            $this->setStarted();

            // Start first Operation
            if ($this->operations->count()) {
                $operation = $this->operations->first();
                $operation->setEventDispatcher($this->eventDispatcher);
                $operation->start();
            }
        }
    }

    /**
     * @see ExecutableInterface::execute()
     */
    public function execute()
    {
        if (!$this->started) {
            throw new \Exception('UnitProcedure not started');
        }

        if (!$this->getCurrentOperation()) {
            $this->setFinished();

            return;
        }

        // Start the next Operation?
        if ($this->getCurrentOperation()->isFinished()) {
            // Go to next unit procedure if possible
            if ($this->operations->next()) {
                $operation = $this->getCurrentOperation();
                $operation->setEventDispatcher($this->eventDispatcher);
                $operation->start();
            } else {
                // If last operation is finished
                // set the finished flag
                $this->setFinished();
            }
        }
        // Execute
        if (!$this->finished &&
                 $this->getCurrentOperation()->isStarted()) {
            // Perform Operation
            $this->getCurrentOperation()->execute();
        }
    }

    /**
     * @return UnitProcedure
     */
    public function setStarted()
    {
        $this->started = true;
        $this->eventDispatcher->dispatch(BrewEvents::UNIT_PROCEDURE_START, new UnitProcedureStartEvent($this));

        return $this;
    }

    /**
     * @return UnitProcedure
     */
    public function setFinished()
    {
        $this->finished = true;
        $this->eventDispatcher->dispatch(BrewEvents::UNIT_PROCEDURE_FINISH, new UnitProcedureFinishEvent($this));

        return $this;
    }

    /**
     * @return Operation|false
     */
    public function getCurrentOperation()
    {
        return $this->operations->current();
    }
}
