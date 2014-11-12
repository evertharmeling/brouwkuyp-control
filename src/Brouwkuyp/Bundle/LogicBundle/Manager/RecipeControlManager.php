<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Brouwkuyp\Bundle\ServiceBundle\Repository\ControlRecipeRepository;
use Doctrine\ORM\EntityManager;
use Brouwkuyp\Bundle\LogicBundle\Model\Procedure;
use Doctrine\ORM\EntityRepository;

/**
 * RecipeControlManager
 */
class RecipeControlManager
{
    /**
     *
     * @var ControlRecipeRepository
     */
    private $controlRecipeRepository;

    /**
     *
     * @param ControlRecipeRepository $controlRecipeRepository            
     */
    public function __construct(ControlRecipeRepository $controlRecipeRepository)
    {
        $this->controlRecipeRepository = $controlRecipeRepository;
    }

    /**
     * Loads MasterRecipe from database and creates ControlRecipe
     *
     * @param
     *            $id
     * @return BatchManager
     * @throws \Exception
     */
    public function load($id)
    {
        echo "RecipeControlManager::load id: " . $id . "\n";
        /**
         * @var ControlRecipe $recipe
         */
        $recipe = $this->controlRecipeRepository->find($id);
        
        if (!is_null($recipe)) {
            // could convert the $recipe Entity to the $receipe Model
            // (if we decide not to let the entity extend the model)
            echo "Loaded recipe: '" . $recipe->getName() . "'\n";
        } else {
            throw new \Exception("Recipe could not be found or loaded");
        }
        
        return new BatchManager($recipe);
    }
}