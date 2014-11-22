<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure;

/**
 * Unit
 */
class Unit
{
    const TYPE_MASHER = 'Masher';
    
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection
     */
    protected $unitProcedures;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unitProcedures = new ArrayCollection();
    }

    /**
     * Gets the name of the unit
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the unit
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Add UnitProcedure
     *
     * @param  UnitProcedure $unitProcedure
     * @return Procedure
     */
    public function addUnitprocedure(UnitProcedure $unitProcedure)
    {
        $this->unitProcedures[] = $unitProcedure;

        return $this;
    }

    /**
     * Remove UnitProcedure
     *
     * @param UnitProcedure $unitProcedure
     */
    public function removeUnitProcedure(UnitProcedure $unitProcedure)
    {
        $this->unitProcedures->removeElement($unitProcedure);
    }

    /**
     * Get UnitProcedure
     *
     * @return ArrayCollection
     */
    public function getUnitProcedures()
    {
        return $this->unitProcedures;
    }
}
