<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\OperationFinishEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class OperationFinishedListener
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
     * @param OperationFinishEvent $event
     */
    public function onOperationFinish(OperationFinishEvent $event)
    {
        $operation = $event->getOperation();
        $this->logManager->log(sprintf("Operation '%s' finished", $operation->getName()));
    }
}
