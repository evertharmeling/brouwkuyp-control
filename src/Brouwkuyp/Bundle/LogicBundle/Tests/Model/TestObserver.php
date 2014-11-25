<?php

namespace Brouwkuyp\Bundle\LogicBundle\Tests\Model;

use Brouwkuyp\Bundle\LogicBundle\Model\ObserverInterface;

class TestObserver implements ObserverInterface
{
    private $notifyCount;

    public function notify()
    {
        $this->notifyCount++;
    }

    public function getNotifyCount()
    {
        return $this->notifyCount;
    }
}
