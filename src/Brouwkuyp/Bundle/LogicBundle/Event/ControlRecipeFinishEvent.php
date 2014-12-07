<?php

namespace Brouwkuyp\Bundle\LogicBundle\Event;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ControlRecipeFinishEvent extends Event
{
    /**
     * @var ControlRecipe
     */
    private $controlRecipe;

    /**
     * @param ControlRecipe $controlRecipe
     */
    public function __construct(ControlRecipe $controlRecipe)
    {
        $this->controlRecipe = $controlRecipe;
    }

    /**
     * @return ControlRecipe
     */
    public function getControlRecipe()
    {
        return $this->controlRecipe;
    }
}
