<?php

namespace Brouwkuyp\Bundle\LogicBundle\Event;

use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PhaseStatusEvent extends Event
{
    /**
     * @var Phase
     */
    private $phase;

    /**
     * @var int
     */
    private $elapsedTime;

    /**
     * @param Phase $phase
     */
    public function __construct(Phase $phase, $elapsedTime)
    {
        $this->phase = $phase;
        $this->elapsedTime = $elapsedTime;
    }

    /**
     * @return Phase
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @return int
     */
    public function getElapsedTime()
    {
        return $this->elapsedTime;
    }
}
