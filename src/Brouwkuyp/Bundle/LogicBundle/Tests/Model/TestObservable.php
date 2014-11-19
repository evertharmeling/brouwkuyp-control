<?php

namespace Brouwkuyp\Bundle\LogicBundle\Tests\Model;

use Brouwkuyp\Bundle\LogicBundle\Model\ObserverInterface as Observer;
use Brouwkuyp\Bundle\LogicBundle\Model\Observable;

class TestObservable extends Observable
{
    public function getObserverCount()
    {
        return $this->observers->count();
    }
}