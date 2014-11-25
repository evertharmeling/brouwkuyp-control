<?php

namespace Brouwkuyp\Bundle\LogicBundle\Tests\Model;

use Brouwkuyp\Bundle\LogicBundle\Model\Observable;
use Brouwkuyp\Bundle\LogicBundle\Model\Observer;

/**
 * Tests the abstract Observable class
 */
class ObservableTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var TestObservable
     */
    private $observable;

    /**
     *
     * @var TestObserver
     */
    private $observer;

    protected function setUp()
    {
        parent::setUp();

        $this->observer = new TestObserver();
        $this->observable = new TestObservable();
    }

    public function testRegister()
    {
        $this->assertEquals(0, $this->observable->getObserverCount());
        $this->observable->registerObserver($this->observer);
        $this->assertEquals(1, $this->observable->getObserverCount());
    }

    public function testUnregister()
    {
        $this->observable->registerObserver($this->observer);
        $this->observable->unregisterObserver($this->observer);
        $this->assertEquals(0, $this->observable->getObserverCount());
    }
}
