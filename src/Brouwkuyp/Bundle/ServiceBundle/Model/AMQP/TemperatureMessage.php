<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Model\AMQP;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class TemperatureMessage extends AMQPMessage
{
    /**
     * @param float $value
     * @param array $properties
     */
    public function __construct($value, array $properties = null)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("Value needs to be numeric");
        }

        parent::__construct(floatval($value), $properties);
    }
}
