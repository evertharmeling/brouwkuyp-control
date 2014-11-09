<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure;

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
        $this->showBatch();
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
    
    /**
     * Outputs batch and recipe information
     */
    public function showBatch()
    {
        echo "\n*********************************************\n";
        echo "Recipe: '".$this->recipe->getName()."'\n";
        echo " Procedure: '".$this->recipe->getProcedure()->getName()."'\n";
        echo "  UnitProcedures: \n";
        /** @var UnitProcedure $up */
        foreach ($this->recipe->getProcedure()->getUnitProcedures() as $up)
        {
            echo "   UP: '".$up->getName()."'\n"; 
            echo "    Unit: '".$up->getUnit()->getName()."'\n";
            echo "    Operations: \n";
            /** @var Operation $op */
            foreach ($up->getOperations() as $op)
            {
                echo "     OP: '".$op->getName()."'\n";
                /** @var Phase $phase */
                foreach ($op->getPhases() as $phase)
                {
                    echo "      Phase:  '".$phase->getName()."'\n";
                    echo "       type:  '".$phase->getType()."'\n";
                    echo "       value: '".$phase->getValue()."'\n";
                }
            }
        }
        echo "*********************************************\n\n";
    }
}
