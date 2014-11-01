<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Doctrine\ORM\EntityManager;
use Brouwkuyp\Bundle\LogicBundle\Model\Procedure;

/**
 * RecipeControlManager
 */
class RecipeControlManager
{
    /**
     * Current ControlRecipe
     * 
     * @var \ControlRecipe
     */
    private $recipe;
    
    /**
     * EntityManager
     *
     * @var \EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * Loads MasterRecipe from database and creates ControlRecipe
     *
     * @param $id
     * @throws \Exception
     */
    public function load($id)
    {
        // Load recipe 
        $this->recipe = new ControlRecipe($id);
        $this->recipe->load();
        
        if (is_null($this->recipe)) {
            throw new \Exception("Recipe could not be loaded");
        }
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
