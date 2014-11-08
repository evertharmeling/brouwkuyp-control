<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe as BaseControlRecipe;
use Doctrine\ORM\Mapping as ORM;

/**
 * ControlRecipe
 */
class ControlRecipe extends BaseControlRecipe
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
     * @var integer
     */
    protected $version;

    /**
     * @var string
     */
    protected $remarks;

    /**
     * @var \Brouwkuyp\Bundle\ServiceBundle\Entity\Procedure
     */
    protected $procedure;


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
     * @return ControlRecipe
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
     * Set version
     *
     * @param integer $version
     * @return ControlRecipe
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return ControlRecipe
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string 
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set procedure
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\Procedure $procedure
     * @return ControlRecipe
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
}
