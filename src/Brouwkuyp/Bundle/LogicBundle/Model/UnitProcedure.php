<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * UnitProcedure
 */
class UnitProcedure
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Set name
     *
     * @param  string       $name
     * @return MasterRecipe
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
}
