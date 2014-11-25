<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\Traits\ExecutableTrait;
use Symfony\Component\Stopwatch\Stopwatch;

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
class Phase extends Observable implements ExecutableInterface
{
    use ExecutableTrait;
    const CONTROL_TEMP = 'control_temp';
    const ADD_INGREDIENTS = 'add_ingredients';
    const PRINT_TIMES = 10;
    const NOTIFY_TIMES = 30;
    
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var string
     */
    protected $type;
    
    /**
     *
     * @var integer
     */
    protected $value;
    
    /**
     *
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
        echo sprintf('Phase::start %s', $this->name) . PHP_EOL;
        if (!$this->started) {
            // Set flag that we are started
            $this->started = true;
            $this->executed = 0;
            $this->timer = new Stopwatch();
            $this->timer->start('started');
            $this->notifyObservers();
        }
    }

    /**
     * Executes stage
     */
    public function execute()
    {
        $this->printPhaseExecution();
        if ($this->started) {
            if ($this->getDurationSeconds() > $this->duration) {
                $this->finished = true;
            }else{
                if (($this->executed % Phase::NOTIFY_TIMES) == 0) {
                    $this->notifyObservers();
                }
            }
        } else {
            throw new \Exception('Phase not started');
        }
        $this->executed++;
    }

    private function getDurationSeconds()
    {
        $timerEvent = $this->timer->lap('started');
        return ($timerEvent->getDuration() / 1000);
    }

    private function printPhaseExecution()
    {
        if (($this->executed % Phase::PRINT_TIMES) == 0) {
            echo sprintf('Phase::execute %s (%4d/%4d)', $this->name, 
                    $this->getDurationSeconds(), $this->duration)  . PHP_EOL;
        }
    }
}
