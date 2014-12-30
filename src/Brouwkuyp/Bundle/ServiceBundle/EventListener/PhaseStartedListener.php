<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\PhaseStartEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PhaseStartedListener
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
     * @param PhaseStartEvent $event
     */
    public function onPhaseStart(PhaseStartEvent $event)
    {
        $phase = $event->getPhase();
        $this->logManager->log(sprintf("Phase '%s' to '%s' started", $phase->getName(), $phase->getValue()));
    }
}
