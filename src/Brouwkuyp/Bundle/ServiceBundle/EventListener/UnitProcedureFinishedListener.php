<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureFinishEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class UnitProcedureFinishedListener
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
     * @param UnitProcedureFinishEvent $event
     */
    public function onUnitProcedureFinish(UnitProcedureFinishEvent $event)
    {
        $unitProcedure = $event->getUnitProcedure();
        $this->logManager->log(sprintf("Unit procedure '%s' finished", $unitProcedure->getName()));
    }
}
