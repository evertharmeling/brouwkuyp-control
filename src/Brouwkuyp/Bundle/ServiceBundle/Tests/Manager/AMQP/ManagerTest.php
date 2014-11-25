<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Manager\AMQP;

use Brouwkuyp\Bundle\LogicBundle\Model\Log;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Test\AMQP\AMQPTestCase;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ManagerTest extends AMQPTestCase
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * Setting up the manager
     */
    protected function setUp()
    {
        parent::setUp();

        $this->manager = new Manager($this->conn);
    }

    public function testPublish()
    {
        $this->assertTrue($this->manager->publish(new AMQPMessage(80), Log::TOPIC_MLT_SET_TEMP));
    }
}
