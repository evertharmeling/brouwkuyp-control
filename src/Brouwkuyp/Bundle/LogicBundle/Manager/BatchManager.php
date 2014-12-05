<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Brouwkuyp\Bundle\LogicBundle\Model\ObserverInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\Operation;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure;
use Brouwkuyp\Bundle\ServiceBundle\Doctrine\DateTime;
use Brouwkuyp\Bundle\ServiceBundle\Entity\Batch;
use Doctrine\ORM\EntityManager;

/**
 * BatchManager
 *
 * Control the chosen recipe and log all relevant information
 * during the batch.
 */
class BatchManager implements ObserverInterface
{
    /**
     *
     * @var EquipmentManager
     */
    private $equipmentManager;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Phase
     */
    private $observablePhase;

    /**
     *
     * @var Batch
     */
    private $batch;

    /**
     * @param EntityManager    $entityManager
     * @param EquipmentManager $equipmentManager
     */
    public function __construct(EntityManager $entityManager, EquipmentManager $equipmentManager)
    {
        $this->entityManager = $entityManager;
        $this->equipmentManager = $equipmentManager;
    }

    /**
     * Create a batch from a Recipe.
     *
     * @param  ControlRecipe $recipe
     * @return Batch
     */
    public function createBatch(ControlRecipe $recipe)
    {
        $this->batch = new Batch($recipe);
        $this->batch->setCreatedAt(new DateTime());
        $this->entityManager->persist($this->batch);
        $this->entityManager->flush();

        return $this->batch;
    }

    /**
     * Starts the recipe that is loaded
     */
    public function start(Batch $batch = null)
    {
        if (is_null($batch)) {
            $batch = $this->batch;
        }
        // Print recipe
        $this->showBatch($batch);

        // register us as observer
        $this->registerOnPhases();

        // Start the procedure to follow this recipe
        $batch->start();
    }

    /**
     * Executes a given batch or the current active batch.
     */
    public function execute(Batch $batch = null)
    {
        if (is_null($batch)) {
            $batch = $this->batch;
        }
        $batch->execute();
    }

    /**
     * Outputs batch and recipe information
     *
     * @param Batch $batch
     */
    public function showBatch(Batch $batch = null)
    {
        if (is_null($batch)) {
            if(is_null($this->batch)) {
                throw new \Exception('No Batch to show');
            }
            $batch = $this->batch;
        }
        echo PHP_EOL . "*********************************************" .
                 PHP_EOL;
        echo sprintf("Recipe: '%s'", $batch->getRecipe()->getName()) .
                 PHP_EOL;
        echo sprintf(" Procedure: '%s'",
                $batch->getRecipe()->getProcedure()->getName()) .
                 PHP_EOL;
        echo "  UnitProcedures: " . PHP_EOL;
        /**
         *
         * @var UnitProcedure $up
         */
        foreach ($batch->getRecipe()->getProcedure()->getUnitProcedures() as $up) {
            echo sprintf("   UP: '%s'", $up->getName()) . PHP_EOL;
            echo sprintf("    Unit: '%s'", $up->getUnit()->getName()) .
                     PHP_EOL;
            echo "    Operations: " . PHP_EOL;
            /**
             *
             * @var Operation $op
             */
            foreach ($up->getOperations() as $op) {
                echo sprintf("     OP: '%s'", $op->getName()) . PHP_EOL;
                /**
                 *
                 * @var Phase $phase
                 */
                foreach ($op->getPhases() as $phase) {
                    echo sprintf("      Phase:  '%s'",
                            $phase->getName()) . PHP_EOL;
                    echo sprintf("       type:  '%s'",
                            $phase->getType()) . PHP_EOL;
                    echo sprintf("       value: '%s'",
                            $phase->getValue()) . PHP_EOL;
                    echo sprintf("       duration: '%s'",
                            $phase->getDuration()) . PHP_EOL;
                }
            }
        }
        echo "*********************************************" . PHP_EOL .
                 PHP_EOL;
    }

    /**
     * We're being notified so save the current Phase and
     * let the equipment perform the task that is needed to execute the Phase.
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ObserverInterface::notify()
     */
    public function notify()
    {
        // Maybe Phase changed
        $this->observablePhase = $this->batch->getRecipe()->getProcedure()->getCurrentUnitProcedure()->getCurrentOperation()->getCurrentPhase();
        // Execute task for this Phase
        $this->equipmentManager->performTaskFor(
                $this->observablePhase);
    }

    /**
     * Checks if the batch is still in operation
     *
     * @var bool
     */
    public function isRunning(Batch $batch = null)
    {
        if (is_null($batch)) {
            $batch = $this->batch;
        }

        return ($batch->isStarted() && !$batch->isFinished());
    }

    /**
     * Registers this BatchManager on all Phases as an observer
     */
    private function registerOnPhases()
    {
        foreach ($this->batch->getRecipe()->getProcedure()->getUnitProcedures() as $up) {
            foreach ($up->getOperations() as $op) {
                foreach ($op->getPhases() as $observable) {
                    $observable->registerObserver($this);
                }
            }
        }
    }
}
