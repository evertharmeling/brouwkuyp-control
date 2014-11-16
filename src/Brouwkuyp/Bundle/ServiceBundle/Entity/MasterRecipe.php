<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\MasterRecipe as BaseMasterRecipe;

/**
 * MasterRecipe
 */
class MasterRecipe extends BaseMasterRecipe
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
