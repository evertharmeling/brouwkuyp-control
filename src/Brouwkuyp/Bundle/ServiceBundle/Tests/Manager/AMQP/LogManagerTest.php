<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Tests\Manager\AMQP;

use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\LogManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Test\AMQP\AMQPTestCase;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class LogManagerTest extends AMQPTestCase
{
    /**
     * @var LogManager
     */
    private $logManager;

    protected function setUp()
    {
        parent::setUp();

        $this->logManager = new LogManager(new Manager($this->conn));
    }

    public function testBroadcastDialog()
    {
        $this->assertTrue($this->logManager->dialog('Add ingredients', 'Operator, add the pils malt'));
        $this->assertTrue($this->logManager->dialog('Add ingredients', 'Operator, add the wheat malt'));
        $this->assertTrue($this->logManager->dialog('Add ingredients', 'Operator, add the oatmeal'));
    }

    public function testBroadcastLog()
    {
        $this->assertTrue($this->logManager->log("'Pre heat' at 52°C"));
        $this->assertTrue($this->logManager->log("'Infusion' at 52°C"));
        $this->assertTrue($this->logManager->log("'Beta amylase' at 62°C"));
        $this->assertTrue($this->logManager->log("'Alpha amylase' at 72°C"));
        $this->assertTrue($this->logManager->log("'Stop' at 78°C"));
        $this->assertTrue($this->logManager->log("'Spool' at 80°C"));
    }
}
