<?php

namespace Brouwkuyp\Bundle\LogicBundle\Event;

use Brouwkuyp\Bundle\LogicBundle\Model\Operation;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class OperationStartEvent extends Event
{
    /**
     * @var Operation
     */
    private $operation;

    /**
     * @param Operation $operation
     */
    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
}
