<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe;
use Brouwkuyp\Bundle\ServiceBundle\Repository\ControlRecipeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class RecipeController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        $recipes = $this->getControlRecipeRepository()->findAll();

        return [
            'recipes' => $recipes
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

    /**
     * @return ControlRecipeRepository
     */
    private function getControlRecipeRepository()
    {
        return $this->container->get('brouwkuyp_service.repository.control_recipe');
    }
}
