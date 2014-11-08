<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

/**
 * BatchControlFactory
 * 
 * Creates S88 objects
 */
abstract class BatchControlFactory
{
    /**
     * Loads the correct ControlRecipe
     * 
     * @param Integer $id
     * @return \ControlRecipe
     */
    abstract public function loadControlRecipe($id);
}
