<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class DialogMessage extends AMQPMessage
{
    /**
     * @param string $title
     * @param string $text
     * @param array  $properties
     */
    public function __construct($title, $text, array $properties = null)
    {
        if (!is_string($title) && !is_string($text)) {
            throw new \InvalidArgumentException(sprintf("'title' and 'text' must be of type string"));
        }

        parent::__construct(json_encode([
            'title' => $title,
            'text' => $text
        ]), $properties);
    }
}
