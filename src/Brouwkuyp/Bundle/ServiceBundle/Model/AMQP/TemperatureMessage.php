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
        parent::__construct(floatval($value), $properties);
    }
}
