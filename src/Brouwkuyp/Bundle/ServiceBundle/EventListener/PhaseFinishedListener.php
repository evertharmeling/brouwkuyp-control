<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\PhaseFinishEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PhaseFinishedListener
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
     * @param PhaseFinishEvent $event
     */
    public function onPhaseFinish(PhaseFinishEvent $event)
    {
        $phase = $event->getPhase();
        $this->logManager->log(sprintf("Phase '%s' finished", $phase->getName()));
    }
}
