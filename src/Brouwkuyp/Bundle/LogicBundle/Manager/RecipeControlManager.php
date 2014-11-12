<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Brouwkuyp\Bundle\ServiceBundle\Repository\ControlRecipeRepository;

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
        echo sprintf("RecipeControlManager::load id: '%s'", $id) . PHP_EOL;
        /** @var ControlRecipe $recipe */
        $recipe = $this->controlRecipeRepository->find($id);

        if (is_null($recipe)) {
            throw new \Exception("Recipe could not be found or loaded");
        }

        // could convert the $recipe Entity to the $receipe Model
        // (if we decide not to let the entity extend the model)
        echo sprintf("Loaded recipe: '%s'", $recipe->getName()) . PHP_EOL;

        return new BatchManager($recipe);
    }
}
