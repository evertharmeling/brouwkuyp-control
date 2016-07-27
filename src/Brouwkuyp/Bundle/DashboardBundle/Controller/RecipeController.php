<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe;
use Brouwkuyp\Bundle\ServiceBundle\Repository\ControlRecipeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class RecipeController
{
    /**
     * @var ControlRecipeRepository
     */
    private $controlRecipeRepository;

    /**
     * @param ControlRecipeRepository $controlRecipeRepository
     */
    public function __construct($controlRecipeRepository)
    {
        $this->controlRecipeRepository = $controlRecipeRepository;
    }

    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'recipes' => $this->controlRecipeRepository->findAll()
        ];
    }

    /**
     * @Template
     */
    public function detailAction(ControlRecipe $recipe)
    {
        return [
            'recipe' => $recipe
        ];
    }
}
