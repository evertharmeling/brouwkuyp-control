<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface;

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
    /**
     *
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection
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
     * Flag indicating that this UnitProcedure is started.
     *
     * @var bool
     */
    protected $started;
    
    /**
     * Flag indicating that this UnitProcedure is performed and finished.
     *
     * @var bool
     */
    protected $finished;

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
     * @param string $name            
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
     * @param Operation $operation
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
     * @param Procedure $procedure
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
     * @param Unit $unit
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
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::start()
     */
    public function start()
    {
        echo "   UnitProcedure::start, unit: ".$this->unit->getName()."\n";
        if (! $this->started) {
            // Set flag that we are started
            $this->started = true;
        
            // Start first UnitProcedure
            if ($this->operations->count()) {
                $this->operations->first()->start();
            }
        }
    }

    /**
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     */
    public function execute()
    {
        echo "   UnitProcedure::execute, unit: ".$this->unit->getName()."\n";
        if ($this->started) {
            if (!$this->getCurrentOperation()) {
                $this->finished = true;
                return;
            }
        
            // Start the next unit procedure?
            if ($this->getCurrentOperation()->isFinished()) {
                // Go to next unit procedure if possible
                if ($this->operations->next()) {
                    $this->getCurrentOperation()->start();
        
                    // Execute
                    if ($this->getCurrentOperation()->isStarted()) {
                        // Perform unit procedure
                        $this->$this->getCurrentOperation()->execute();
                    }
                } else {
                    // If last unit procedure is finished
                    // set the finished flag
                    $this->finished = true;
                }
            }
        } else {
            throw new \Exception('UnitProcedure not started');
        }
    }

    /**
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        return $this->finished;
    }
    
    public function getCurrentOperation()
    {
        return $this->operations->current();
    }
}
