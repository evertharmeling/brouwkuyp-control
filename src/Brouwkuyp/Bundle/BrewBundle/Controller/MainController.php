<?php

namespace Brouwkuyp\Bundle\BrewBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [];
    }
}
