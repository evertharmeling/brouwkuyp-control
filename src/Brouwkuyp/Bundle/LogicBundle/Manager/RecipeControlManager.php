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
     * BatchControlFactory
     *
     * @var \BatchControlFactory
     */
    private $batchControlFactory;

    /**
     * @param \BatchControlFactory $bcf
     */
    public function __construct($bcf)
    {
        $this->batchControlFactory = $bcf;
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
        $recipe = $this->batchControlFactory->loadControlRecipe($id);
        
        if(!is_null($recipe)){
            echo "Recipe :'".$recipe->getName()."' loaded \n";
            $recipe->load();
        }else{
            throw new \Exception("Recipe could not be found or loaded");
        }
        
        return new BatchManager($recipe);
    }
}
