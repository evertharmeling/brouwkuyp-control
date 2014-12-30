<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\ProcedureStartEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ProcedureStartedListener
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
     * @param ProcedureStartEvent $event
     */
    public function onProcedureStart(ProcedureStartEvent $event)
    {
        $procedure = $event->getProcedure();
        $this->logManager->log(sprintf("Procedure '%s' started", $procedure->getName()));
    }
}
