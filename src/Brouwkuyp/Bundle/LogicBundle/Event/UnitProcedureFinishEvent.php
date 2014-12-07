<?php

namespace Brouwkuyp\Bundle\LogicBundle\Event;

use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class UnitProcedureFinishEvent extends Event
{
    /**
     * @var UnitProcedure
     */
    private $unitProcedure;

    /**
     * @param UnitProcedure $unitProcedure
     */
    public function __construct(UnitProcedure $unitProcedure)
    {
        $this->unitProcedure = $unitProcedure;
    }

    /**
     * @return UnitProcedure
     */
    public function getUnitProcedure()
    {
        return $this->unitProcedure;
    }
}
