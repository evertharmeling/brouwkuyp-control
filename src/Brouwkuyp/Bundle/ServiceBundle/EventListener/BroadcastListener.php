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
use Brouwkuyp\Bundle\LogicBundle\Event\PhaseStatusEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\PhaseTemperatureReachedEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\ProcedureFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\ProcedureStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BroadcastListener
{
    /**
     * @var LogManager
     */
    private $logManager;

    /**
     * @param LogManager $logManager
     */
    public function __construct(LogManager $logManager)
    {
        $this->logManager = $logManager;
    }

    /**
     * @param BatchStartEvent $event
     */
    public function onBatchStart(BatchStartEvent $event)
    {
        $batch = $event->getBatch();
        $this->logManager->log('Batch started');
    }

    /**
     * @param ControlRecipeStartEvent $event
     */
    public function onControlRecipeStart(ControlRecipeStartEvent $event)
    {
        $controlRecipe = $event->getControlRecipe();
        $this->logManager->log('Control recipe started');
    }

    /**
     * @param ProcedureStartEvent $event
     */
    public function onProcedureStart(ProcedureStartEvent $event)
    {
        $procedure = $event->getProcedure();
        $this->logManager->log(sprintf("Procedure '%s' started", $procedure->getName()));
    }

    /**
     * @param UnitProcedureStartEvent $event
     */
    public function onUnitProcedureStart(UnitProcedureStartEvent $event)
    {
        $unitProcedure = $event->getUnitProcedure();
        $this->logManager->log(sprintf("Unit procedure '%s' started", $unitProcedure->getName()));
    }

    /**
     * @param OperationStartEvent $event
     */
    public function onOperationStart(OperationStartEvent $event)
    {
        $operation = $event->getOperation();
        $this->logManager->log(sprintf("Operation '%s' started", $operation->getName()));
    }

    /**
     * @param PhaseStartEvent $event
     */
    public function onPhaseStart(PhaseStartEvent $event)
    {
        $phase = $event->getPhase();
        $this->logManager->log(sprintf("Phase '%s' to '%s' started", $phase->getName(), $phase->getValue()));
    }

    /**
     * @param PhaseStatusEvent $event
     */
    public function onPhaseStatus(PhaseStatusEvent $event)
    {
        $phase = $event->getPhase();

        switch ($phase->getType()) {
            case Phase::CONTROL_TEMP:
                $this->logManager->log(sprintf("Phase '%s' : %d / %d seconds (%d min)", $phase->getName(), $event->getElapsedTime(), $phase->getDuration(), $phase->getDuration() / 60));
                break;
            case Phase::ADD_INGREDIENTS:
                $this->logManager->dialog('Voeg ingrediënten toe', $phase->getName(), $this->getIdentifier($phase));
                break;
        }
    }

    /**
     * @param PhaseTemperatureReachedEvent $event
     */
    public function onPhaseTemperatureReached(PhaseTemperatureReachedEvent $event)
    {
        $phase = $event->getPhase();
        $this->logManager->log(sprintf("Phase '%s' temperature '%d' reached", $phase->getName(), $phase->getValue()));
    }

    /**
     * @param PhaseFinishEvent $event
     */
    public function onPhaseFinish(PhaseFinishEvent $event)
    {
        $phase = $event->getPhase();
        $this->logManager->log(sprintf("Phase '%s' finished", $phase->getName()));
    }

    /**
     * @param OperationFinishEvent $event
     */
    public function onOperationFinish(OperationFinishEvent $event)
    {
        $operation = $event->getOperation();
        $this->logManager->log(sprintf("Operation '%s' finished", $operation->getName()));
    }

    /**
     * @param UnitProcedureFinishEvent $event
     */
    public function onUnitProcedureFinish(UnitProcedureFinishEvent $event)
    {
        $unitProcedure = $event->getUnitProcedure();
        $this->logManager->log(sprintf("Unit procedure '%s' finished", $unitProcedure->getName()));
    }

    /**
     * @param ProcedureFinishEvent $event
     */
    public function onProcedureFinish(ProcedureFinishEvent $event)
    {
        $procedure = $event->getProcedure();
        $this->logManager->log(sprintf("Procedure '%s' finished", $procedure->getName()));
    }

    /**
     * @param ControlRecipeFinishEvent $event
     */
    public function onControlRecipeFinish(ControlRecipeFinishEvent $event)
    {
        $controlRecipe = $event->getControlRecipe();
        $this->logManager->log('Control recipe finished');
    }

    /**
     * @param BatchFinishEvent $event
     */
    public function onBatchFinish(BatchFinishEvent $event)
    {
        $batch = $event->getBatch();
        $this->logManager->log('Batch finished');
    }

    /**
     * @param  object $object
     * @return string
     */
    private function getIdentifier($object)
    {
        $reflection = new \ReflectionClass($object);

        return sprintf("%s.%d", strtolower($reflection->getShortName()), $object->getId());
    }
}
