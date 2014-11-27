<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Arduino;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Pump;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\BrewControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Test\AMQP\AMQPTestCase;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PumpTest extends AMQPTestCase
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
        $this->brewControlManager->setPumpState(Pump::STATE_AUTOMATIC);
        // Pump (led) should become active
        sleep(5);
        $this->brewControlManager->setMashTemperature(-2);
        // Pump (led) should become inactive
        sleep(5);
        $this->brewControlManager->setMashTemperature(64);
        // Pump (led) should become active
    }
}
