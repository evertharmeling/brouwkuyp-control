<?php

namespace Brouwkuyp\Bundle\LogicBundle\Event;

use Brouwkuyp\Bundle\LogicBundle\Model\Batch;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BatchCompleteEvent extends Event
{
    /**
     * @var Batch
     */
    private $batch;

    /**
     * @param Batch $batch
     */
    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return Batch
     */
    public function getBatch()
    {
        return $this->batch;
    }
}
