<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * ExecutableInterface
 */
interface ExecutableInterface
{
    /**
     * Starts stage
     */
    public function start();
    
    /**
     * Executes stage
     */
    public function execute();
<<<<<<< HEAD

    /**
     * Returns state
     *
=======
    
    /**
     * Returns started state
     */
    public function isStarted();
    
    /**
     * Returns finished state
     * 
>>>>>>> Added new models
     * @return bool
     */
    public function isFinished();
}
