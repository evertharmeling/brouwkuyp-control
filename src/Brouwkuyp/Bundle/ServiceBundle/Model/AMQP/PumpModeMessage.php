<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Model\AMQP;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Pump;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PumpModeMessage extends AMQPMessage
{
    /**
     * @param string $value
     * @param array  $properties
     */
    public function __construct($value, array $properties = null)
    {
        if (!in_array($value, Pump::getPossibleModes())) {
            throw new \InvalidArgumentException(sprintf("'%s' is not a valid pump mode", $value));
        }

        parent::__construct($value, $properties);
    }
}
