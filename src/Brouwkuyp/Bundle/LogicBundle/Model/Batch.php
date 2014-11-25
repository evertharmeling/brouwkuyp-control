<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * Batch
 */
class Batch implements ExecutableInterface
{
    /**
     *
     * @var ControlRecipe
     */
    protected $control_recipe;

    /**
     * Timer for monitoring the duration
     *
     * @var Stopwatch
     */
    protected $timer;

    /**
     * Creation date and time
     * @var DateTime
     */
    protected $createdAt;

    /**
     * Construct the batch corresponding to the selected Recipe.
     * @param ControlRecipe $recipe
     */
    public function __construct(ControlRecipe $recipe)
    {
        $this->control_recipe = $recipe;
    }

    /**
     *
     * @see ExecutableInterface::start()
     * @throws \Exception
     */
    public function start()
    {
        echo 'Batch::start' . PHP_EOL;
        if (is_null($this->control_recipe)) {
            throw new \Exception('No Recipe for this Batch');
        }

        if ($this->control_recipe->isFinished()) {
            throw new \Exception('Procedure already finished');
        }

        $this->control_recipe->start();
    }

    /**
     *
     * @see ExecutableInterface::execute()
     * @throws \Exception
     */
    public function execute()
    {
        if (is_null($this->control_recipe)) {
            throw new \Exception('No Recipe for this Batch');
        }

        if (!$this->control_recipe->isFinished()) {
            $this->control_recipe->execute();
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
        return $this->control_recipe->isStarted();
    }

    /**
     *
     * @see ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        return $this->control_recipe->isFinished();
    }

    /**
     * Set ControlRecipe
     *
     * @param  ControlRecipe $recipe
     * @return Batch
     */
    public function setRecipe(ControlRecipe $recipe)
    {
        $this->control_recipe = $recipe;

        return $this;
    }

    /**
     * Get ControlRecipe
     *
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->control_recipe;
    }
}
