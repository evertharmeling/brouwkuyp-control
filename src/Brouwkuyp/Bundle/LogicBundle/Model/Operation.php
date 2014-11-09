<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

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
class Operation implements ExecutableInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection
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
     * @param string $name
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
     * @param Phase $phase
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
     * @return ArrayCollection
     */
    public function getPhases()
    {
        return $this->phases;
    }

    /**
     * Set UnitProcedure
     *
     * @param UnitProcedure $unitProcedure
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
     * Starts stage
     */
    public function start()
    {
        echo "    Operation::start: '".$this->name."'\n";
    }
    
    /**
     * Executes stage
     */
    public function execute()
    {
        echo "    Operation::execute: '".$this->name."'\n";
    }
    
    /**
     * Returns started state
     *
     * @return bool
     */
    public function isStarted()
    {
    
    }
    
    /**
     * Returns finished state
     *
     * @return bool
     */
    public function isFinished()
    {
    
    }
}
