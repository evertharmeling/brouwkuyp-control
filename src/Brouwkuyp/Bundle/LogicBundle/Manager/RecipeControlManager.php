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

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * Loads MasterRecipe from database and creates ControlRecipe
     *
     * @param integer $id            
     */
    public function load($id)
    {
        if ($id == 0) {
            // Id 1 is the hardcoded recipe for a dubbel beer
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
