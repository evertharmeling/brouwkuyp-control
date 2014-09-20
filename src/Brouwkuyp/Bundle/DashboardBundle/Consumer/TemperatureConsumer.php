<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class TemperatureConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        var_dump($msg->body);
    }
}
