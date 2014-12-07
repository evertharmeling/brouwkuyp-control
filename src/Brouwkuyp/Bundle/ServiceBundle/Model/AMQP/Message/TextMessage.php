<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class TextMessage extends AMQPMessage
{
    /**
     * @param string $value
     * @param array  $properties
     */
    public function __construct($value, array $properties = null)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException(sprintf("The passed value must be of type string"));
        }

        parent::__construct($value, $properties);
    }
}
