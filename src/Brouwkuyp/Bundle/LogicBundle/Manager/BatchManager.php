<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe;
use Brouwkuyp\Bundle\LogicBundle\Model\ObservableInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\ObserverInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\Operation;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure;
use Brouwkuyp\Bundle\ServiceBundle\Doctrine\DateTime;
use Brouwkuyp\Bundle\ServiceBundle\Entity\Batch;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * BatchManager
 *
 * Control the chosen recipe and log all relevant information
 * during the batch.
 */
class BatchManager implements ObserverInterface
{
    /**
     * @var EquipmentManager
     */
    private $equipmentManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Phase
     */
    private $observablePhase;

    /**
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
    public function createBatch(ControlRecipe $recipe, EventDispatcherInterface $eventDispatcher)
    {
        $this->batch = new Batch($recipe, $eventDispatcher);
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
     * We're being notified so save the current Phase and
     * let the equipment perform the task that is needed to execute the Phase.
     *
     * @see ObserverInterface::notify()
     */
    public function notify()
    {
        // Maybe Phase changed
        $this->observablePhase = $this->batch->getRecipe()->getProcedure()->getCurrentUnitProcedure()->getCurrentOperation()->getCurrentPhase();
        // Execute task for this Phase
        $this->equipmentManager->performTaskFor($this->observablePhase);
    }

    /**
     * Checks if the batch is still in operation
     *
     * @param  Batch $batch
     * @return bool
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
        /** @var UnitProcedure $up */
        foreach ($this->batch->getRecipe()->getProcedure()->getUnitProcedures() as $up) {
            /** @var Operation $op */
            foreach ($up->getOperations() as $op) {
                /** @var ObservableInterface $observable */
                foreach ($op->getPhases() as $observable) {
                    $observable->registerObserver($this);
                }
            }
        }
    }
}
