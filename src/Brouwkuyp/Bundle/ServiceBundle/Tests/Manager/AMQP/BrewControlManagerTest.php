<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Manager\AMQP;

use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\BrewControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Test\AMQP\AMQPTestCase;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BrewControlManagerTest extends AMQPTestCase
{
    /**
     * @var BrewControlManager
     */
    private $brewControlManager;

    protected function setUp()
    {
        parent::setUp();

        $this->brewControlManager = new BrewControlManager(new Manager($this->conn));
    }

    public function testPublish()
    {
        $this->assertTrue($this->brewControlManager->setMashTemperature(62));
    }
}
