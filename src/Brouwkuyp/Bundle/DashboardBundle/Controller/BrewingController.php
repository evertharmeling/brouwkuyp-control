<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrewingController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        $recipes = [];

        return [
            'recipes' => $recipes
        ];
    }
}
