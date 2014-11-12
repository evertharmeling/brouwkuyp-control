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

    /**
     * Returns started state
     *
     * @return bool
     */
    public function isStarted();

    /**
     * Returns finished state
     *
     * @return bool
     */
    public function isFinished();
}
