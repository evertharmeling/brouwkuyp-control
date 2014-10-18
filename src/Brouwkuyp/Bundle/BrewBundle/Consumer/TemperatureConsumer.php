<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

class TemperatureConsumer
{
    public function execute(AMQPMessage $msg)
    {
        var_dump($msg->body);
    }
}
