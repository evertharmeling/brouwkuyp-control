<?php

namespace Brouwkuyp\Bundle\LogicBundle\Traits;

use Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface;

/**
 * ExecutableTrait
 */
trait ExecutableTrait
{
    /**
     * Flag indicating that this object is started.
     *
     * @var bool
     */
    protected $started;

    /**
     * Flag indicating that this object is performed and finished.
     *
     * @var bool
     */
    protected $finished;

    /**
     *
     * @see ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     *
     * @see ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        return $this->finished;
    }
}
