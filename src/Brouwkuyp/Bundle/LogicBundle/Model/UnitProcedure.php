<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\Traits\ExecutableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Unit;

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
class UnitProcedure implements ExecutableInterface
{
    use ExecutableTrait;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var ArrayCollection
     */
    protected $operations;

    /**
     *
     * @var Procedure
     */
    protected $procedure;

    /**
     *
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
     * @return ArrayCollection
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
     *
     * @see ExecutableInterface::start()
     */
    public function start()
    {
        echo "   UnitProcedure::start, unit: " . $this->unit->getName() . "\n";
        if (!$this->started) {
            // Set flag that we are started
            $this->started = true;

            // Start first Operation
            if ($this->operations->count()) {
                $this->operations->first()->start();
            }
        }
    }

    /**
     *
     * @see ExecutableInterface::execute()
     */
    public function execute()
    {
        echo "   UnitProcedure::execute, unit: " . $this->unit->getName() . "\n";
        if (!$this->started) {
            throw new \Exception('UnitProcedure not started');
        }

        if (!$this->getCurrentOperation()) {
            $this->finished = true;

            return;
        }

        // Start the next Operation?
        if ($this->getCurrentOperation()->isFinished()) {
            // Go to next unit procedure if possible
            if ($this->operations->next()) {
                $this->getCurrentOperation()->start();
            } else {
                // If last operation is finished
                // set the finished flag
                $this->finished = true;
            }
        }
        // Execute
        if (!$this->finished && $this->getCurrentOperation()->isStarted()) {
            // Perform Operation
            $this->getCurrentOperation()->execute();
        }
    }

    /**
     * @return Operation|false
     */
    public function getCurrentOperation()
    {
        return $this->operations->current();
    }
}
