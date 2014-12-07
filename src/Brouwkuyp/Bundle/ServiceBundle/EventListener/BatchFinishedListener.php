<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\BatchFinishEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BatchFinishedListener
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
     * @param BatchFinishEvent $event
     */
    public function onBatchFinish(BatchFinishEvent $event)
    {
        $batch = $event->getBatch();
        $this->logManager->log('Batch finished');
    }
}
