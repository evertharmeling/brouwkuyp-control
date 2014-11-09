<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;

/**
 * BatchManager
 * 
 * Control the chosen recipe and log all relevant information
 * during the batch.
 */
class BatchManager
{
    /**
     * @var ControlRecipe
     */
    private $recipe;

    /**
     * @param ControlRecipe $recipe
     */
    public function __construct(ControlRecipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * Starts the recipe that is loaded
     */
    public function start()
    {
        echo "BatchManager::start \n";
        $this->recipe->start();
    }
    
    /**
     * Executes current active recipe
     */
    public function execute()
    {
        echo "BatchManager::execute \n";
        $this->recipe->execute();
    }
}
