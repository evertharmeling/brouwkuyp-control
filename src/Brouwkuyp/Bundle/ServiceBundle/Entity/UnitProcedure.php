<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure as BaseUnitProcedure;

/**
 * UnitProcedure
 */
class UnitProcedure
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
    protected $operation;

    /**
     * @var \Brouwkuyp\Bundle\ServiceBundle\Entity\Procedure
     */
    protected $procedure;

    /**
     * @var \Brouwkuyp\Bundle\ServiceBundle\Entity\Unit
     */
    protected $unit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operation = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\Operation $operation
     * @return UnitProcedure
     */
    public function addOperation(\Brouwkuyp\Bundle\ServiceBundle\Entity\Operation $operation)
    {
        $this->operation[] = $operation;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\Operation $operation
     */
    public function removeOperation(\Brouwkuyp\Bundle\ServiceBundle\Entity\Operation $operation)
    {
        $this->operation->removeElement($operation);
    }

    /**
     * Get operation
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set procedure
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\Procedure $procedure
     * @return UnitProcedure
     */
    public function setProcedure(\Brouwkuyp\Bundle\ServiceBundle\Entity\Procedure $procedure = null)
    {
        $this->procedure = $procedure;

        return $this;
    }

    /**
     * Get procedure
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\Procedure 
     */
    public function getProcedure()
    {
        return $this->procedure;
    }

    /**
     * Set unit
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\Unit $unit
     * @return UnitProcedure
     */
    public function setUnit(\Brouwkuyp\Bundle\ServiceBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
