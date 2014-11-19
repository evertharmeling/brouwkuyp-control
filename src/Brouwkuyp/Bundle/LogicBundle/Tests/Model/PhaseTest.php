<?php

namespace Brouwkuyp\Bundle\LogicBundle\Tests\Model;

use Brouwkuyp\Bundle\LogicBundle\Model\Observer;
use Brouwkuyp\Bundle\LogicBundle\Model\Observable;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\LogicBundle\Model\Operation;

/**
 * Tests the Phase class
 */
class PhaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Phase
     */
    private $phase;
    
    /**
     *
     * @var TestObserver
     */
    private $observer;

    protected function setUp()
    {
        parent::setUp();
        
        $this->observer = new TestObserver();
        $this->phase = new Phase();
    }

    public function testRegisterUnregister()
    {
        $this->phase->notifyObservers();
        $this->phase->registerObserver($this->observer);
        $this->phase->notifyObservers();
        $this->assertEquals(1, $this->observer->getNotifyCount());
        $this->phase->unregisterObserver($this->observer);
        $this->phase->notifyObservers();
        $this->assertEquals(1, $this->observer->getNotifyCount());
    }
    
    public function testNotify()
    {
        $this->phase->notifyObservers();
        $this->phase->registerObserver($this->observer);
        $this->phase->notifyObservers();
        $this->assertEquals(1, $this->observer->getNotifyCount());
        $this->phase->unregisterObserver($this->observer);
        $this->phase->notifyObservers();
        $this->assertEquals(1, $this->observer->getNotifyCount());
    }
    
    public function testSetGetName()
    {
        $this->phase->setName("crazy");
        $this->assertEquals("crazy",$this->phase->getName());
    }
    
    public function testSetGetOperation()
    {
        $operation = new Operation();
        $operation->setName("psych op");
        $this->phase->setOperation($operation);
        $this->assertEquals("psych op",$this->phase->getOperation()->getName());
    }
}
