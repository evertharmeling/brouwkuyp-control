<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\Model\ObserverInterface;

interface ObservableInterface
{   
    /**
     * Function to add a observer/listener
     * 
     * @param ObserverInterface
     */
    public function registerObserver(ObserverInterface $observer);
    
    /**
     * Function to add a observer/listener
     * 
     * @param ObserverInterface
     */
    public function unregisterObserver(ObserverInterface $observer);
    
    /**
     * Function to notify all the observers/listeners
     * that some data/state is changed.
     */
    public function notifyObservers();
}