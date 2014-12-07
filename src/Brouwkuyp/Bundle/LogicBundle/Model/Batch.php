<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Symfony\Component\Stopwatch\StopwatchEvent;
use Brouwkuyp\Bundle\LogicBundle\BrewEvents;
use Brouwkuyp\Bundle\LogicBundle\Event\BatchCompleteEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\BatchStartEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Batch
 */
class Batch implements ExecutableInterface
{
    /**
     * @var ControlRecipe
     */
    protected $controlRecipe;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

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
    public function __construct(ControlRecipe $recipe, EventDispatcherInterface $eventDispatcher)
    {
        $this->controlRecipe = $recipe;
        $this->eventDispatcher = $eventDispatcher;

        $this->setBatch();
        $this->timer = new Stopwatch();
    }

    /**
     *
     * @see ExecutableInterface::start()
     * @throws \Exception
     */
    public function start()
    {
        if (is_null($this->controlRecipe)) {
            throw new \Exception('No Recipe for this Batch');
        }

        if ($this->controlRecipe->isFinished()) {
            throw new \Exception('Procedure already finished');
        }

        $this->eventDispatcher->dispatch(BrewEvents::BATCH_START, new BatchStartEvent($this));
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
            $this->eventDispatcher->dispatch(BrewEvents::BATCH_COMPLETE, new BatchCompleteEvent($this));
        }
    }

    /**
     * @see ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        return $this->controlRecipe->isStarted();
    }

    /**
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
    public function setControlRecipe(ControlRecipe $controlRecipe)
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
    
    /**
     * Create a timer event
     * 
     * @param string $batchElementName
     * @param string $eventName
     * @return StopwatchEvent
     */
    public function startTimer($batchElementName, $eventName)
    {
        return $this->timer->start($batchElementName.":".$eventName);
    }
    
    public function getDuration($batchElementName, $eventName)
    {
        $event = $this->timer->lap($batchElementName.":".$eventName);
        return $event->getDuration();
    }
    
    /**
     * @todo should not be necessary because of the relation
     *
     * Sets the batch for all elements.
     */
    private function setBatch()
    {
        $this->controlRecipe->setBatch($this);
        $this->controlRecipe->getProcedure()->setBatch($this);
        foreach ($this->controlRecipe->getProcedure()->getUnitProcedures() as $up) {
            $up->setBatch($this);
            foreach ($up->getOperations() as $op) {
                $op->setBatch($this);
                foreach ($op->getPhases() as $phase) {
                    $phase->setBatch($this);
                }
            }
        }
    }
}
