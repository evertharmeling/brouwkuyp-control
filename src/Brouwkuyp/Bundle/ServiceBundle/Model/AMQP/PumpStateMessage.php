<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Model\AMQP;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PumpStateMessage extends AMQPMessage
{
    /**
     * @param bool $value
     * @param array $properties
     */
    public function __construct($value, array $properties = null)
    {
        parent::__construct((bool) $value, $properties);
    }
}
