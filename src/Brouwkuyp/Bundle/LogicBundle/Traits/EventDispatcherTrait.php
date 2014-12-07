<?php

namespace Brouwkuyp\Bundle\LogicBundle\Traits;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
trait EventDispatcherTrait
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
}
