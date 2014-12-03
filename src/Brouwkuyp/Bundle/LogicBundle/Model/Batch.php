<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Batch
 */
class Batch implements ExecutableInterface
{
    /**
     *
     * @var ControlRecipe
     */
    protected $controlRecipe;

    /**
     * @var MasterRecipe
     */
    protected $masterRecipe;

    /**
     * Timer for monitoring the duration
     *
     * @var Stopwatch
     */
    protected $timer;

    /**
     * Creation date and time
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Construct the batch corresponding to the selected Recipe.
     * @param ControlRecipe $recipe
     */
    public function __construct(ControlRecipe $recipe)
    {
        $this->controlRecipe = $recipe;
    }

    /**
     *
     * @see ExecutableInterface::start()
     * @throws \Exception
     */
    public function start()
    {
        echo 'Batch::start' . PHP_EOL;
        if (is_null($this->controlRecipe)) {
            throw new \Exception('No Recipe for this Batch');
        }

        if ($this->controlRecipe->isFinished()) {
            throw new \Exception('Procedure already finished');
        }

        $this->controlRecipe->start();
    }

    /**
     *
     * @see ExecutableInterface::execute()
     * @throws \Exception
     */
    public function execute()
    {
        if (is_null($this->controlRecipe)) {
            throw new \Exception('No Recipe for this Batch');
        }

        if (!$this->controlRecipe->isFinished()) {
            $this->controlRecipe->execute();
        } else {
            echo 'Batch is done' . PHP_EOL;
        }
    }

    /**
     *
     * @see ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        return $this->controlRecipe->isStarted();
    }

    /**
     *
     * @see ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        return $this->controlRecipe->isFinished();
    }

    /**
     * Set controlRecipe
     *
     * @param  ControlRecipe $controlRecipe
     * @return Batch
     */
    public function setControlRecipe(ControlRecipe $controlRecipe = null)
    {
        $this->controlRecipe = $controlRecipe;

        return $this;
    }

    /**
     * Get controlRecipe
     *
     * @return ControlRecipe
     */
    public function getControlRecipe()
    {
        return $this->controlRecipe;
    }

    /**
     * Is this method necessary or could we just use the getControlRecipe in the BatchManager?
     *
     * @return ControlRecipe
     */
    public function getRecipe()
    {
        return $this->getControlRecipe();
    }

    /**
     * Set master_recipe
     *
     * @param  MasterRecipe $masterRecipe
     * @return Batch
     */
    public function setMasterRecipe(MasterRecipe $masterRecipe = null)
    {
        $this->masterRecipe = $masterRecipe;

        return $this;
    }

    /**
     * Get master_recipe
     *
     * @return MasterRecipe
     */
    public function getMasterRecipe()
    {
        return $this->masterRecipe;
    }
}
