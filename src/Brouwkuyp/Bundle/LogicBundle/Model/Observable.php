<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\Model\ObservableInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\ObserverInterface;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Observable implements ObservableInterface
{
    /**
     *
     * @var ArrayCollection
     */
    protected $observers;

    /**
     *
     * @param ObserverInterface $observer            
     */
    public function registerObserver(ObserverInterface $observer)
    {
        if (is_null($this->observers)) {
            $this->observers = new ArrayCollection();
        }
        $this->observers->add($observer);
    }

    /**
     *
     * @param ObserverInterface $observer            
     */
    public function unregisterObserver(ObserverInterface $observer)
    {
        $this->observers->removeElement($observer);
    }

    /**
     * Notify the observers that the data/state changed
     */
    public function notifyObservers()
    {
        /**
         * ObserverInterface
         */
        if (!is_null($this->observers)) {
            foreach ( $this->observers as $observer ) {
                echo "notifying one observer \n";
                    $observer->notify();
                }
        }
    }
}