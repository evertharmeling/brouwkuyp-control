<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Procedure as BaseProcedure;

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
     * @var \Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe
     */
    protected $controlrecipe;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $unitprocedure;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unitprocedure = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set controlrecipe
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe $controlrecipe
     * @return Procedure
     */
    public function setControlrecipe(\Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe $controlrecipe = null)
    {
        $this->controlrecipe = $controlrecipe;

        return $this;
    }

    /**
     * Get controlrecipe
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe 
     */
    public function getControlrecipe()
    {
        return $this->controlrecipe;
    }

    /**
     * Add unitprocedure
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure $unitprocedure
     * @return Procedure
     */
    public function addUnitprocedure(\Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure $unitprocedure)
    {
        $this->unitprocedure[] = $unitprocedure;

        return $this;
    }

    /**
     * Remove unitprocedure
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure $unitprocedure
     */
    public function removeUnitprocedure(\Brouwkuyp\Bundle\ServiceBundle\Entity\UnitProcedure $unitprocedure)
    {
        $this->unitprocedure->removeElement($unitprocedure);
    }

    /**
     * Get unitprocedure
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnitprocedure()
    {
        return $this->unitprocedure;
    }
}
