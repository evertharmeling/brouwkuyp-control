<?php

namespace Brouwkuyp\Bundle\LogicBundle\Traits;

use Brouwkuyp\Bundle\LogicBundle\Model\Batch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * BatchElementTrait
 */
trait BatchElementTrait
{
    /**
     * Batch that we belong to
     *
     * @var Batch
     */
    protected $batch;

    /**
     * Timer event
     *
     * @var StopwatchEvent
     */
    protected $timerEvent;

    /**
     * Sets the parent batch for this child/element.
     *
     * @param Batch $batch
     */
    public function setBatch(Batch $batch)
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

    /**
     * Gets the duration in seconds
     *
     * @return integer duration
     */
    public function getDurationSeconds()
    {
        return ($this->batch->getDuration($this->name, 'start') / 1000);
    }
}
