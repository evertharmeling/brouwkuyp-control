<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

/**
 * BatchManager
 * 
 * Control the chosen recipe and log all relavant information
 * during the batch.
 */
class BatchManager
{
    
    /**
     * @var \ControlRecipe recipe
     */
    private $recipe;
    
    /**
     * @param \ControlRecipe $recipe
     */
    public function __construct(\ControlRecipe $recipe)
    {
        $this->recipe = $recipe;
    }
    /**
     * Starts the recipe that is loaded
     */
    public function start(){
        $this->recipe->start();
    }
    
    /**
     * Executes current active recipe
     */
    public function execute()
    {
        $this->recipe->execute();
    }
}
