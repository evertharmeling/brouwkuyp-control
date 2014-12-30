<?php

namespace Brouwkuyp\Bundle\LogicBundle\Event;

use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PhaseStartEvent extends Event
{
    /**
     * @var Phase
     */
    private $phase;

    /**
     * @param Phase $phase
     */
    public function __construct(Phase $phase)
    {
        $this->phase = $phase;
    }

    /**
     * @return Phase
     */
    public function getPhase()
    {
        return $this->phase;
    }
}
