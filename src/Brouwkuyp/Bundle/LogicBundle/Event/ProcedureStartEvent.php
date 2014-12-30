<?php

namespace Brouwkuyp\Bundle\LogicBundle\Event;

use Brouwkuyp\Bundle\LogicBundle\Model\Procedure;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ProcedureStartEvent extends Event
{
    /**
     * @var Procedure
     */
    private $procedure;

    /**
     * @param Procedure $procedure
     */
    public function __construct(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }

    /**
     * @return Procedure
     */
    public function getProcedure()
    {
        return $this->procedure;
    }
}
