<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Manager\AMQP;

use Brouwkuyp\Bundle\LogicBundle\Model\Log;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Test\AMQP\AMQPTestCase;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\NullLogger;

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
        $this->assertTrue($this->manager->publish(new AMQPMessage(60), Log::TOPIC_MASHER_SET_TEMP));
    }

    public function testSetLogger()
    {
        $this->manager->setLogger(new NullLogger());
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $this->manager->getLogger());
    }

    public function testInvalidLogger()
    {
        $this->setExpectedException(get_class(new \PHPUnit_Framework_Error("",0,"",1)));
        $this->manager->setLogger(new \stdClass());
        $this->assertNotInstanceOf('Psr\Log\LoggerInterface', $this->manager->getLogger());
    }
}
