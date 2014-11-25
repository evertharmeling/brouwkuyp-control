<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe as BaseControlRecipe;

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
     * @var integer
     */
    protected $version;

    /**
     * @var string
     */
    protected $remarks;

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
     * Set version
     *
     * @param  integer       $version
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
     * @param  string        $remarks
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
     * Set name
     *
     * @param  string        $name
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
     * Get procedure
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\Procedure
     */
    public function getProcedure()
    {
        return $this->procedure;
    }
}
