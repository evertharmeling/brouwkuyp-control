<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class Manager
{
    const MESSAGE_TYPE  = 'topic';
    const CHANNEL_NAME  = 'amq.topic';
    const TOPIC_NAME    = 'php-client';

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

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param AMQPStreamConnection $conn
     */
    public function __construct(AMQPStreamConnection $conn)
    {
        $this->conn = $conn;
        $this->channel = $conn->channel();

        list($this->queueName) = $this->channel->queue_declare('', false, true, true, false);

        $this->channel->exchange_declare(self::TOPIC_NAME, self::MESSAGE_TYPE, false, true, true, false);
    }

    /**
     * @param AMQPMessage $message
     * @param string      $routingKey
     */
    public function publish(AMQPMessage $message, $routingKey = '')
    {
        $this->getLogger()->info('amqp.publish', [
            'route' => $routingKey,
            'value' => $message->body
        ]);
        $this->channel->basic_publish($message, self::CHANNEL_NAME, $routingKey);
    }

    /**
     * @param callable $callback
     * @param string   $routingKey, default to all ('#')
     */
    public function consume(callable $callback, $routingKey = '#')
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
     * @throws AMQPRuntimeException
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

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        if ($this->logger) {
            return $this->logger;
        }

        return $this->logger = new NullLogger();
    }
}
