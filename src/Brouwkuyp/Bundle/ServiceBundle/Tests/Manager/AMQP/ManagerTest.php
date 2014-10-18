<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Manager;

use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Monolog\Logger;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    private $manager;

    protected function setUp()
    {
        parent::setUp();

        $this->manager = new Manager(new AMQPStreamConnection('localhost', 5672, 'guest', 'guest'));
    }

    public function testPublish()
    {
        $routingKey = 'brewery.brewhouse01.masher.set_temp';

        $message = new AMQPMessage(62);
        $this->manager->publish($message, $routingKey);
    }
}
