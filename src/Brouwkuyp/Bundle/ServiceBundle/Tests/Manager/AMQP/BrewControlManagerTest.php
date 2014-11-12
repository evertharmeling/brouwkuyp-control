<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Manager\AMQP;

use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\BrewControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BrewControlManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BrewControlManager
     */
    private $brewControlManager;

    protected function setUp()
    {
        parent::setUp();

        $manager = new Manager(new AMQPStreamConnection('localhost', 5672, 'guest', 'guest'));
        $this->brewControlManager = new BrewControlManager($manager);
    }

    public function testPublish()
    {
        $this->brewControlManager->setMashTemperature(62);
    }
}
