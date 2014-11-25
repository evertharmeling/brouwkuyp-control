<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

interface ObserverInterface
{
    /**
     * Function to notify the observer that the
     * Observable is changed.
     */
    public function notify();
}
