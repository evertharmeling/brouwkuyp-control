<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPManager
{
    /**
     * @var AMQPStreamConnection
     */
    protected $conn;

    /**
     * @var AMQPChannel
     */
    protected $channel;

    public function __construct(AMQPStreamConnection $conn)
    {
        $this->conn = $conn;
        $this->channel = $conn->channel();

        list($queueName) = $this->channel->queue_declare('', false, true, true, false);

        //$this->channel->queue_bind($queueName, 'amq.topic', 'brewery.#');
        $this->channel->exchange_declare('', 'amp.topic', false, true, true, false);
    }

    /**
     * @param AMQPMessage $message
     */
    public function publish(AMQPMessage $message)
    {
        $this->channel->basic_publish($message);
    }
}
