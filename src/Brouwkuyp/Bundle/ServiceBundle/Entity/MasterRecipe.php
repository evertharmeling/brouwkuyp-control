<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Entity\MasterRecipe as BaseMasterRecipe;

/**
 * MasterRecipe
 */
class MasterRecipe extends BaseMasterRecipe
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
}
