<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Operation as BaseOperation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Operation
 */
class Operation extends BaseOperation
{

    /**
     * @var integer
     */
    protected $id;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
    public function setUnitProcedure(\Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure $unitProcedure = null)
    {
        $this->unitProcedure = $unitProcedure;

        return $this;
    }

    /**
     * Get UnitProcedure
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure 
     */
    public function getUnitProcedure()
    {
        return $this->unitProcedure;
    }
}
