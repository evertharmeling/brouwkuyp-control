<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

/**
 * MasterRecipe
 */
class MasterRecipe
{
    /**
     * @var integer
     */
    private $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
