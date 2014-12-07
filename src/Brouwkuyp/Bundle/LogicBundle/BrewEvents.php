<?php

namespace Brouwkuyp\Bundle\LogicBundle;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
final class BrewEvents
{
    /**
     * The batch.start event is thrown each time a batch starts in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\BatchStartEvent instance.
     *
     * @var string
     */
    const BATCH_START = 'batch.start';

    /**
     * The batch.start event is thrown each time a batch completes in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\BatchCompleteEvent instance.
     *
     * @var string
     */
    const BATCH_COMPLETE = 'batch.complete';
}
