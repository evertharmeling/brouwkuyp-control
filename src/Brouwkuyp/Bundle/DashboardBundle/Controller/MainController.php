<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
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
