<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Arduino;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Pump;
use Brouwkuyp\Bundle\LogicBundle\Model\Log;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\BrewControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\PumpModeMessage;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\PumpStateMessage;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\TemperatureMessage;
use Brouwkuyp\Bundle\ServiceBundle\Test\AMQP\AMQPTestCase;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PumpTest extends AMQPTestCase
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
    public function testPump()
    {
        $this->brewControlManager->setPumpState(Pump::STATE_ON);
        sleep(5);
        $this->brewControlManager->setPumpState(Pump::STATE_OFF);
    }

    /**
     * Visual test:
     * - PUMP led should be inactive
     * - PUMP led should become active
     * - PUMP led should become inactive
     * - PUMP led should become active
     *
     * @depends testPump
     */
    public function testPumpStateAutomatic()
    {
        $this->brewControlManager->setMashTemperature(64);
        // Pump (led) should be inactive because it's still in manual state
        sleep(5);
        $this->brewControlManager->setPumpMode(Pump::MODE_AUTOMATIC);
        // Pump (led) should become active
        sleep(5);
        $this->brewControlManager->setMashTemperature(-2);
        // Pump (led) should become inactive
        sleep(5);
        $this->brewControlManager->setMashTemperature(64);
        // Pump (led) should become active
    }

    public function testDashboard()
    {
        $this->manager->publish(new TemperatureMessage(1), Log::TOPIC_HLT_CURR_TEMP);
        $this->manager->publish(new TemperatureMessage(2), Log::TOPIC_MLT_CURR_TEMP);
        $this->manager->publish(new TemperatureMessage(3), Log::TOPIC_BLT_CURR_TEMP);
        $this->brewControlManager->setMashTemperature(4);
        $this->manager->publish(new PumpModeMessage(Pump::MODE_AUTOMATIC), Log::TOPIC_PUMP_CURR_MODE);
        usleep(500000);
        $this->manager->publish(new PumpModeMessage(Pump::MODE_MANUAL), Log::TOPIC_PUMP_CURR_MODE);
        usleep(500000);
        $this->manager->publish(new PumpStateMessage(Pump::STATE_ON), Log::TOPIC_PUMP_CURR_STATE);
        usleep(500000);
        $this->manager->publish(new PumpStateMessage(Pump::STATE_OFF), Log::TOPIC_PUMP_CURR_STATE);
        usleep(500000);
        $this->manager->publish(new PumpModeMessage(Pump::MODE_AUTOMATIC), Log::TOPIC_PUMP_CURR_MODE);
        usleep(500000);
        $this->manager->publish(new PumpModeMessage(Pump::MODE_MANUAL), Log::TOPIC_PUMP_CURR_MODE);
    }
}
