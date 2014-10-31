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
        if ($id == null) {
            // Check database for active control recipe
        } elseif ($id === 1) {
            // If there is a recipe active, try to resume it
        } else if ($id === 1) {
            $this->loadRecipeDubbel();
        } else {
            // Load recipe from database
        }
    }

    public function execute()
    {
    }

    public function save()
    {
    }

    private function loadRecipeDubbel()
    {
        $this->recipe = new ControlRecipe();
        $procedure = new Procedure();
        $this->recipe->setProcedure($procedure);
    }
}
