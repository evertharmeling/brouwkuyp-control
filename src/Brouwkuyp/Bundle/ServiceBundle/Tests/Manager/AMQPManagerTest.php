<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Manager;

use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQPManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evert.harmeling@freshheads.com>
 */
class AMQPManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AMQPManager
     */
    private $manager;

    protected function setUp()
    {
        parent::setUp();

        $this->manager = new AMQPManager(new AMQPStreamConnection('localhost', 5672, 'guest', 'guest'));
    }

    public function testPublish()
    {
        $routingKey = 'brewery.brewhouse01.masher.set_temp';

        $message = new AMQPMessage(62);
        $this->manager->publish($message, $routingKey);
    }
}
