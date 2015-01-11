<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Arduino;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Pump;
use Brouwkuyp\Bundle\LogicBundle\Model\Log;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\BrewControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message\PumpStateMessage;
use Brouwkuyp\Bundle\ServiceBundle\Test\AMQP\AMQPTestCase;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class LEDTest extends AMQPTestCase
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var BrewControlManager
     */
    private $brewControlManager;

    protected function setUp()
    {
        parent::setUp();

        $this->manager = new Manager($this->conn);
        $this->brewControlManager = new BrewControlManager($this->manager);
    }

    /**
     * Visual test:
     * - PUMP led should be inactive
     * - PUMP led should become active
     * - PUMP led should become inactive
     */
    public function testRelaisLEDs()
    {
        $this->brewControlManager->setMashTemperature(22);
    }

    /**
     * Visual test:
     * - PUMP led should be on
     * - PUMP led should be off
     * - PUMP led should be on
     */
    public function testRelaisPump()
    {
        echo 'Pump - 9 - OFF' . PHP_EOL;
        $this->manager->publish(new PumpStateMessage(Pump::STATE_OFF), Log::TOPIC_PUMP_CURR_STATE);
        $this->manager->publish(new PumpStateMessage(Pump::STATE_ON), Log::TOPIC_PUMP_CURR_STATE);
        echo 'Pump - 9 - ON' . PHP_EOL;
        sleep(5);
        $this->manager->publish(new PumpStateMessage(Pump::STATE_OFF), Log::TOPIC_PUMP_CURR_STATE);
        echo 'Pump - 9 - OFF' . PHP_EOL;
    }
}
