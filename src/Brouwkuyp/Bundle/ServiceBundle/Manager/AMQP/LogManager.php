<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP;

use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message\DialogMessage;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message\LogMessage;

/**
 * @author Evert Harmeling <evert.harmeling@freshheads.com>
 */
class LogManager
{
    const ROUTE_BROADCAST_DIALOG    = 'brewery.brewhouse01.broadcast.dialog';
    const ROUTE_BROADCAST_LOG       = 'brewery.brewhouse01.broadcast.log';

    /**
     * @var Manager
     */
    private $amqpManager;

    /**
     * @param Manager $amqpManager
     */
    public function __construct(Manager $amqpManager)
    {
        $this->amqpManager = $amqpManager;
    }

    /**
     * @param  mixed $value
     * @return bool
     */
    public function log($value)
    {
        return $this->amqpManager->publish(new LogMessage($value), self::ROUTE_BROADCAST_LOG);
    }

    /**
     * @param $title
     * @param $text
     * @return bool
     */
    public function dialog($title, $text)
    {
        return $this->amqpManager->publish(new DialogMessage($title, $text), self::ROUTE_BROADCAST_DIALOG);
    }
}
