<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Manager\AMQP;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Pump;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\BrewControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Test\AMQP\AMQPTestCase;

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

    public function testSetMashTemperature()
    {
        $this->assertTrue($this->brewControlManager->setMashTemperature(62));
    }

    public function testSetPumpState()
    {
        $this->assertTrue($this->brewControlManager->setPumpState(Pump::STATE_ON));
        $this->assertTrue($this->brewControlManager->setPumpState(Pump::STATE_OFF));
    }

    public function testSetPumpMode()
    {
        $this->assertTrue($this->brewControlManager->setPumpMode(Pump::MODE_AUTOMATIC));
        $this->assertTrue($this->brewControlManager->setPumpMode(Pump::MODE_MANUAL));
    }

    public function testBroadcastDialog()
    {
        $this->assertTrue($this->brewControlManager->broadcastDialog('Add ingredients', 'Operator, add the pils malt'));
        $this->assertTrue($this->brewControlManager->broadcastDialog('Add ingredients', 'Operator, add the wheat malt'));
        $this->assertTrue($this->brewControlManager->broadcastDialog('Add ingredients', 'Operator, add the oatmeal'));
    }

    public function testBroadcastLog()
    {
        $this->assertTrue($this->brewControlManager->broadcastLog("'Pre heat' at 52°C"));
        $this->assertTrue($this->brewControlManager->broadcastLog("'Infusion' at 52°C"));
        $this->assertTrue($this->brewControlManager->broadcastLog("'Beta amylase' at 62°C"));
        $this->assertTrue($this->brewControlManager->broadcastLog("'Alpha amylase' at 72°C"));
        $this->assertTrue($this->brewControlManager->broadcastLog("'Stop' at 78°C"));
        $this->assertTrue($this->brewControlManager->broadcastLog("'Spool' at 80°C"));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMashTemperature()
    {
        $this->assertTrue($this->brewControlManager->setMashTemperature('test'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidPumpState()
    {
        $this->brewControlManager->setPumpState('test');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidPumpMode()
    {
        $this->brewControlManager->setPumpMode('test');
    }
}
