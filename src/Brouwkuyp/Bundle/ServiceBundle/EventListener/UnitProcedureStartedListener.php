<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureStartEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class UnitProcedureStartedListener
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
     * @param UnitProcedureStartEvent $event
     */
    public function onUnitProcedureStart(UnitProcedureStartEvent $event)
    {
        $unitProcedure = $event->getUnitProcedure();
        $this->logManager->log(sprintf("Unit procedure '%s' started", $unitProcedure->getName()));
    }
}
