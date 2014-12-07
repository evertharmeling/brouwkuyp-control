<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class LogMessage extends AMQPMessage
{
    /**
     * @param string $text
     * @param array  $properties
     */
    public function __construct($text, array $properties = null)
    {
        if (!is_string($text)) {
            throw new \InvalidArgumentException(sprintf("'text' must be of type string"));
        }

        parent::__construct($text, $properties);
    }
}
