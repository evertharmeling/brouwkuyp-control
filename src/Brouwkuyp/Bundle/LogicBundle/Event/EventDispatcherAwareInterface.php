<?php

namespace Brouwkuyp\Bundle\LogicBundle\Event;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author  Evert Harmeling <evertharmeling@gmail.com>
 */
interface EventDispatcherAwareInterface
{
    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @return $this
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher);
}
