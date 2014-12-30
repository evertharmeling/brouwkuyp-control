<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\ProcedureFinishEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ProcedureFinishedListener
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
     * @param ProcedureFinishEvent $event
     */
    public function onProcedureFinish(ProcedureFinishEvent $event)
    {
        $procedure = $event->getProcedure();
        $this->logManager->log(sprintf("Procedure '%s' finished", $procedure->getName()));
    }
}
