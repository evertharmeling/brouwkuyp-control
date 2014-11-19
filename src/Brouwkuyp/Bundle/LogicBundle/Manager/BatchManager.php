<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Brouwkuyp\Bundle\LogicBundle\Model\Operation;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure;
use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\ObserverInterface;

/**
 * BatchManager
 *
 * Control the chosen recipe and log all relevant information
 * during the batch.
 */
class BatchManager implements ObserverInterface
{
    /**
     * @var ControlRecipe
     */
    private $recipe;
    
    /**
     * @var BrewControlManagerInterface
     */
    private $bcm;

    /**
     * @param ControlRecipe $recipe
     */
    public function __construct(ControlRecipe $recipe, BrewControlManagerInterface $bcm)
    {
        $this->recipe = $recipe;
        $this->bcm = $bcm;
    }

    /**
     * Starts the recipe that is loaded
     */
    public function start()
    {
        echo "BatchManager::start \n";
        $this->showBatch();
        
        // register us as observer
        $observablePhase = $this->recipe->getProcedure()->getCurrentUnitProcedure()->getCurrentOperation()->getCurrentPhase();
        $observablePhase->registerObserver($this);
        
        $this->recipe->start();
    }

    /**
     * Executes current active recipe
     */
    public function execute()
    {
        echo "\nBatchManager::execute \n";
        $this->recipe->execute();
    }

    /**
     * Outputs batch and recipe information
     */
    public function showBatch()
    {
        echo PHP_EOL . "*********************************************" . PHP_EOL;
        echo sprintf("Recipe: '%s'", $this->recipe->getName()) . PHP_EOL;
        echo sprintf(" Procedure: '%s'", $this->recipe->getProcedure()->getName()) . PHP_EOL;
        echo "  UnitProcedures: " . PHP_EOL;
        /** @var UnitProcedure $up */
        foreach ($this->recipe->getProcedure()->getUnitProcedures() as $up) {
            echo sprintf("   UP: '%s'", $up->getName()) . PHP_EOL;
            echo sprintf("    Unit: '%s'", $up->getUnit()->getName()) . PHP_EOL;
            echo "    Operations: " . PHP_EOL;
            /** @var Operation $op */
            foreach ($up->getOperations() as $op) {
                echo sprintf("     OP: '%s'", $op->getName()) . PHP_EOL;
                /** @var Phase $phase */
                foreach ($op->getPhases() as $phase) {
                    echo sprintf("      Phase:  '%s'", $phase->getName()) . PHP_EOL;
                    echo sprintf("       type:  '%s'", $phase->getType()) . PHP_EOL;
                    echo sprintf("       value: '%s'", $phase->getValue()) . PHP_EOL;
                }
            }
        }
        echo "*********************************************" . PHP_EOL . PHP_EOL;
    }
    
    /**
     * @return \Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface
     */
    /*public function getBrewControlManager()
    {
        return $this->bcm;
    }*/
    
    public function notify()
    {
        echo "something changed in the model \n";
        $this->bcm->setMashTemperature(50.0);
    }
}
