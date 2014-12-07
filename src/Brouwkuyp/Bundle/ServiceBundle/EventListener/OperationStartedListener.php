<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\OperationStartEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class OperationStartedListener
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
     * @param OperationStartEvent $event
     */
    public function onOperationStart(OperationStartEvent $event)
    {
        $operation = $event->getOperation();
        $this->logManager->log(sprintf("Operation '%s' started", $operation->getName()));
    }
}
