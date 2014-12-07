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
        if (!is_scalar($title) && !is_scalar($text)) {
            throw new \InvalidArgumentException(sprintf("'title' and 'text' must be a scalar"));
        }

        parent::__construct(json_encode([
            'title' => $title,
            'text' => $text
        ]), $properties);
    }
}
