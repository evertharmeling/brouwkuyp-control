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
    
    /**
     * Returns state
     * 
     * @return bool
     */
    public function isFinished();
}
