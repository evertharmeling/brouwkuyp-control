<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\LogicBundle\Event\ControlRecipeFinishEvent;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ControlRecipeFinishedListener
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
     * @param ControlRecipeFinishEvent $event
     */
    public function onControlRecipeFinish(ControlRecipeFinishEvent $event)
    {
        $controlRecipe = $event->getControlRecipe();
        $this->logManager->log('Control recipe finished');
    }
}
