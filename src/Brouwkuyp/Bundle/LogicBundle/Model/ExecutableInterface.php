<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * ExecutableInterface
 */
interface ExecutableInterface
{

    /**
     * Executes current stage/step
     */
    public function execute();
<<<<<<< HEAD

    /**
     * Returns state
     *
=======
    
    /**
     * Returns state
     * 
>>>>>>> Added new models
     * @return bool
     */
    public function isFinished();
}
