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
<<<<<<< HEAD
     * @param integer $id
=======
     * @param integer $id            
>>>>>>> Added new models
     */
    public function load($id)
    {
        if ($id == null) {
            // Check database for active control recipe
<<<<<<< HEAD
        } elseif ($id === 1) {
=======
        } else if ($id === 1) {
>>>>>>> Added new models
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
