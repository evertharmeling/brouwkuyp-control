<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\ControlRecipeStartEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ControlRecipeStartedListener
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
     * @param ControlRecipeStartEvent $event
     */
    public function onControlRecipeStart(ControlRecipeStartEvent $event)
    {
        $controlRecipe = $event->getControlRecipe();
        $this->logManager->log('Control recipe started');
    }
}
