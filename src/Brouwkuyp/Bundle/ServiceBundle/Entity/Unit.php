<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Unit as BaseUnit;

/**
 * Unit
 */
class Unit extends BaseUnit
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
        $this->unitProcedures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Unit
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
     * Get unitProcedures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnitProcedures()
    {
        return $this->unitProcedures;
    }
}
