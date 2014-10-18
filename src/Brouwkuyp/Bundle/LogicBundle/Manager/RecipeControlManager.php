<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Doctrine\ORM\EntityManager;
use Brouwkuyp\Bundle\LogicBundle\Model\Procedure;

/**
 * RecipeControlManager
 */
class RecipeControlManager
{
    /**
     *
     * @var ControlRecipe
     */
    private $recipe;
    
    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * Loads MasterRecipe from database and creates ControlRecipe
     *
     * @param $id
     * @throws \Exception
     */
    public function load($id)
    {
        if ($id == null) {
            // Check database for active control recipe
        } elseif ($id === 1) {
            $this->loadRecipeDubbel();
        } else {
            // Load recipe from database
        }
        
        if (is_null($this->recipe)) {
            throw new \Exception("Recipe could not be loaded");
        }
    }

    public function execute()
    {
    }

    public function save()
    {
    }

    /**
     * Temp test function
     */
    private function loadRecipeDubbel()
    {
        $this->recipe = new ControlRecipe(-1);
    }
}
