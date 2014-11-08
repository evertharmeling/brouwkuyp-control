<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Operation as BaseOperation;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $phase;

    /**
     * @var \Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure
     */
    protected $unitprocedure;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phase = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\Phase $phase
     * @return Operation
     */
    public function addPhase(\Brouwkuyp\Bundle\ServiceBundle\Entity\Phase $phase)
    {
        $this->phase[] = $phase;

        return $this;
    }

    /**
     * Remove phase
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\Phase $phase
     */
    public function removePhase(\Brouwkuyp\Bundle\ServiceBundle\Entity\Phase $phase)
    {
        $this->phase->removeElement($phase);
    }

    /**
     * Get phase
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * Set unitprocedure
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure $unitprocedure
     * @return Operation
     */
    public function setUnitprocedure(\Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure $unitprocedure = null)
    {
        $this->unitprocedure = $unitprocedure;

        return $this;
    }

    /**
     * Get unitprocedure
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure 
     */
    public function getUnitprocedure()
    {
        return $this->unitprocedure;
    }
}
