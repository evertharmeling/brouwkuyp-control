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

    const CONTROL_TEMP      = 'control_temp';
    const ADD_INGREDIENTS   = 'add_ingredients';

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
     * Timer for monitoring the duration
     * 
     * @var Stopwatch
     */
    protected $timer;

    /**
     * Set name
     *
     * @param  string $name
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
     * @param  Operation $operation
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
        echo "      Phase::start: '" . $this->name . "'\n";
        if (!$this->started) {
            // Set flag that we are started
            $this->started = true;
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
        echo "     Phase::execute: '" . $this->name . PHP_EOL;
        if ($this->started) {
            echo sprintf("      duration: '%d'", $this->getDurationSeconds()) . PHP_EOL;
            if($this->getDurationSeconds() > $this->duration){
                $this->finished = true;
            }
        } else{
            throw new \Exception('Phase not started');
        }
    }
    
    private function getDurationSeconds()
    {
        $timerEvent = $this->timer->lap('started');
        return ($timerEvent->getDuration()/1000);
    }
}
