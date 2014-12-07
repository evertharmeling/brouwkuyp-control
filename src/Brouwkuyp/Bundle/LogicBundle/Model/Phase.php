<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\BrewEvents;
use Brouwkuyp\Bundle\LogicBundle\Event\EventDispatcherAwareInterface;
use Brouwkuyp\Bundle\LogicBundle\Event\PhaseFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\PhaseStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Traits\EventDispatcherTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\ExecutableTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\BatchElementTrait;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * Phase
 *
 * A phase is the smallest element of procedural control that can
 * accomplish process-oriented tasks. Phases perform unique and
 * generally independent, basic process-oriented functions,
 * such as charging an ingredient or agitating a tank.
 * Simply put, phases are the workhorses of recipes.
 * All other elements (procedures, unit procedures, and operations)
 * simply group, organize, and direct phases.
 */
class Phase extends Observable implements ExecutableInterface, BatchElementInterface, EventDispatcherAwareInterface
{
    use ExecutableTrait;
    use BatchElementTrait;
    use EventDispatcherTrait;

    const REACH_TEMP        = 'reach_temp';
    const CONTROL_TEMP      = 'control_temp';
    const ADD_INGREDIENTS   = 'add_ingredients';

    const PRINT_TIMES       = 4;
    const NOTIFY_TIMES      = 30;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var integer
     */
    protected $value;
    
    /**
     * @var Operation
     */
    protected $operation;
    
    /**
     * Wanted duration in seconds
     *
     * @var integer
     */
    protected $duration;
    
    /**
     * Counter for the times being executed
     *
     * @var integer
     */
    private $executed;

    /**
     * Set name
     *
     * @param string $name            
     * @return Phase
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set operation
     *
     * @param Operation $operation            
     * @return Phase
     */
    public function setOperation(Operation $operation = null)
    {
        $this->operation = $operation;
        
        return $this;
    }

    /**
     * Get operation
     *
     * @return Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Starts stage
     */
    public function start()
    {
        $this->eventDispatcher->dispatch(BrewEvents::PHASE_START, new PhaseStartEvent($this));

        if (!$this->started) {
            $this->batch->startTimer($this->name, 'start');
            $this->setStarted();
            $this->executed = 0;
            $this->notifyObservers();
        }
    }

    /**
     * Executes stage
     */
    public function execute()
    {
        // TODO: now the Phase and the manager decide when the
        // Phase is finished. Only one class should have this responsibility
        if ($this->started) {
            if ($this->finished) {
                $this->notifyObservers();
            } else {
                switch ($this->type) {
                    case Phase::CONTROL_TEMP:
                    case Phase::ADD_INGREDIENTS:
                        $this->printPhaseExecution(true);
                        if ($this->getDurationSeconds() > $this->duration) {
                            $this->setFinished();
                        }
                        if (($this->executed % Phase::NOTIFY_TIMES) == 0) {
                            $this->notifyObservers();
                        }
                        break;
                    case Phase::REACH_TEMP:
                        $this->printPhaseExecution(false);
                        $this->notifyObservers();
                        break;
                    default:
                        throw new \Exception('Unknown Phase type');
                }
            }
        } else {
            throw new \Exception('Phase not started');
        }
        
        ++$this->executed;
    }

    /**
     * @return Phase
     */
    public function setStarted()
    {
        $this->started = true;
        $this->eventDispatcher->dispatch(BrewEvents::PHASE_START, new PhaseStartEvent($this));

        return $this;
    }

    /**
     * Function to finish the Phase
     */
    public function setFinished()
    {
        $this->finished = true;
        $this->eventDispatcher->dispatch(BrewEvents::PHASE_FINISH, new PhaseFinishEvent($this));

        return $this;
    }

    private function printPhaseExecution($showDuration)
    {
        if (($this->executed % Phase::PRINT_TIMES) == 0) {
            if ($showDuration == true) {
                echo sprintf('Phase::execute %s (%4d/%4d)', 
                        $this->name, $this->getDurationSeconds(), 
                        $this->duration) . PHP_EOL;
            } else {
                echo sprintf('Phase::execute %s', $this->name) .
                         PHP_EOL;
            }
        }
    }
}
