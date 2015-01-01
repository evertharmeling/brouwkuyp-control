<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\BatchFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\BatchStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\ControlRecipeFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\ControlRecipeStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\OperationFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\OperationStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\PhaseFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\PhaseStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\PhaseTemperatureReachedEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\ProcedureFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\ProcedureStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureStartEvent;
use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Doctrine\ORM\EntityManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class LogListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param BatchStartEvent $event
     */
    public function onBatchStart(BatchStartEvent $event)
    {
        $batch = $event->getBatch();
        $this->log('batch.start', $batch->getId(), $batch);
    }

    /**
     * @param ControlRecipeStartEvent $event
     */
    public function onControlRecipeStart(ControlRecipeStartEvent $event)
    {
        $controlRecipe = $event->getControlRecipe();
        $this->log('control_recipe.start', $controlRecipe->getId(), $controlRecipe->getBatch());
    }

    /**
     * @param ProcedureStartEvent $event
     */
    public function onProcedureStart(ProcedureStartEvent $event)
    {
        $procedure = $event->getProcedure();
        $this->log('procedure.start', $procedure->getId(), $procedure->getBatch());
    }

    /**
     * @param UnitProcedureStartEvent $event
     */
    public function onUnitProcedureStart(UnitProcedureStartEvent $event)
    {
        $unitProcedure = $event->getUnitProcedure();
        $this->log('unit_procedure.start', $unitProcedure->getId(), $unitProcedure->getBatch());
    }

    /**
     * @param OperationStartEvent $event
     */
    public function onOperationStart(OperationStartEvent $event)
    {
        $operation = $event->getOperation();
        $this->log('operation.start', $operation->getId(), $operation->getBatch());
    }

    /**
     * @param PhaseStartEvent $event
     */
    public function onPhaseStart(PhaseStartEvent $event)
    {
        $phase = $event->getPhase();
        $this->log('phase.start', $phase->getId(), $phase->getBatch());
    }

    /**
     * @param PhaseTemperatureReachedEvent $event
     */
    public function onPhaseTemperatureReached(PhaseTemperatureReachedEvent $event)
    {
        $phase = $event->getPhase();
        $this->log('phase.temperature_reached', $phase->getId(), $phase->getBatch());
    }

    /**
     * @param PhaseFinishEvent $event
     */
    public function onPhaseFinish(PhaseFinishEvent $event)
    {
        $phase = $event->getPhase();
        $this->log('phase.finish', $phase->getId(), $phase->getBatch());
    }

    /**
     * @param OperationFinishEvent $event
     */
    public function onOperationFinish(OperationFinishEvent $event)
    {
        $operation = $event->getOperation();
        $this->log('operation.finish', $operation->getId(), $operation->getBatch());
    }

    /**
     * @param UnitProcedureFinishEvent $event
     */
    public function onUnitProcedureFinish(UnitProcedureFinishEvent $event)
    {
        $unitProcedure = $event->getUnitProcedure();
        $this->log('unit_procedure.finish', $unitProcedure->getId(), $unitProcedure->getBatch());
    }

    /**
     * @param ProcedureFinishEvent $event
     */
    public function onProcedureFinish(ProcedureFinishEvent $event)
    {
        $procedure = $event->getProcedure();
        $this->log('procedure.finish', $procedure->getId(), $procedure->getBatch());
    }

    /**
     * @param ControlRecipeFinishEvent $event
     */
    public function onControlRecipeFinish(ControlRecipeFinishEvent $event)
    {
        $controlRecipe = $event->getControlRecipe();
        $this->log('control_recipe.finish', $controlRecipe->getId(), $controlRecipe->getBatch());
    }

    /**
     * @param BatchFinishEvent $event
     */
    public function onBatchFinish(BatchFinishEvent $event)
    {
        $batch = $event->getBatch();
        $this->log('batch.finish', $batch->getId(), $batch);
    }

    /**
     * @param string $identifier
     * @param string $value
     * @param null   $batch
     */
    private function log($identifier, $value, $batch = null)
    {
        $log = new Log();
        $log
            ->setTopic($identifier)
            ->setValue($value)
            ->setBatch($batch)
        ;

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
