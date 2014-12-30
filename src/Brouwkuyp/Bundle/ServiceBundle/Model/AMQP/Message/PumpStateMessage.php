<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Pump;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PumpStateMessage extends TextMessage
{
    /**
     * @param string $value
     * @param array  $properties
     */
    public function __construct($value, array $properties = null)
    {
        if (!in_array($value, Pump::getPossibleStates())) {
            throw new \InvalidArgumentException(sprintf("'%s' is not a valid pump state", $value));
        }

        parent::__construct($value, $properties);
    }
}
