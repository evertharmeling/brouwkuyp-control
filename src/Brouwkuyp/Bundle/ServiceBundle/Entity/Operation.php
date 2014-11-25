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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phases = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get phases
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhases()
    {
        return $this->phases;
    }

    /**
     * Get unitProcedure
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure 
     */
    public function getUnitProcedure()
    {
        return $this->unitProcedure;
    }
}
