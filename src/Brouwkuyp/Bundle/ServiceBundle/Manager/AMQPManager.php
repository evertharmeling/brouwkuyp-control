<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPManager
{
    const MESSAGE_TYPE  = 'topic';
    const CHANNEL_NAME  = 'amq.topic';
    const TOPIC_NAME    = 'brouwkuyp';

    /**
     * @var AMQPStreamConnection
     */
    protected $conn;

    /**
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * @var string
     */
    protected $queueName;

    public function __construct(AMQPStreamConnection $conn)
    {
        $this->conn = $conn;
        $this->channel = $conn->channel();

        list($this->queueName) = $this->channel->queue_declare('', false, true, true, false);

        $this->channel->exchange_declare(self::TOPIC_NAME, self::MESSAGE_TYPE, false, true, true, false);
    }

    /**
     * @param AMQPMessage $message
     * @param string $routingKey
     */
    public function publish(AMQPMessage $message, $routingKey)
    {
        $this->channel->basic_publish($message, self::CHANNEL_NAME, $routingKey);
    }

    /**
     * @param $callback
     * @param string $routingKey
     */
    public function consume($callback, $routingKey = 'brewery.#')
    {
        $this->channel->queue_bind($this->queueName, self::CHANNEL_NAME, $routingKey);
        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);
    }

    /**
     * @return array
     */
    public function receive()
    {
        return $this->channel->callbacks;
    }

    /**
     * @return mixed
     */
    public function wait()
    {
        return $this->channel->wait();
    }

    /**
     * Closes the channel and connection
     */
    public function close()
    {
        $this->channel->close();
        $this->conn->close();
    }
}
