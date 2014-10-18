<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;

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
     * Loads MasterRecipe from database and creates ControlRecipe
     *
     * @param integer $id            
     */
    public function load($id)
    {
        if ($id == null) {
            // Check database for active control recipe
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
        $this->recipe->setProcedure();
    }
}
