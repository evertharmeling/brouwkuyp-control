<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Procedure as BaseProcedure;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Procedure
 */
class Procedure extends BaseProcedure
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
     * @var ControlRecipe
     */
    protected $controlRecipe;

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
     * @return Procedure
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
     * Set ControlRecipe
     *
     * @param ControlRecipe $controlRecipe
     * @return Procedure
     */
    public function setControlRecipe(ControlRecipe $controlRecipe = null)
    {
        $this->controlRecipe = $controlRecipe;

        return $this;
    }

    /**
     * Get controlrecipe
     *
     * @return ControlRecipe 
     */
    public function getControlRecipe()
    {
        return $this->controlRecipe;
    }

    /**
     * Add UnitProcedure
     *
     * @param UnitProcedure $unitProcedure
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
