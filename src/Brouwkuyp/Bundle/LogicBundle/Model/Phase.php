<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

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
class Phase implements ExecutableInterface
{
    const CONTROL_TEMP = 'controltemp';
    const ADD_INGREDIENTS = 'addingr';
    
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
     * Flag indicating that this Phase is started.
     *
     * @var bool
     */
    protected $started;
    
    /**
     * Flag indicating that this Phase is performed and finished.
     *
     * @var bool
     */
    protected $finished;

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
        echo "      Phase::start: '" . $this->name . "'\n";
        if (!$this->started) {
            // Set flag that we are started
            $this->started = true;
        }
    }

    /**
     * Executes stage
     */
    public function execute()
    {
        echo "     Phase::execute: '" . $this->name . "'\n";
        if ($this->started) {
            if(!$this->finished){
                $this->checkAndUpdateProgress();
                $this->performTask();
            }
        } else {
            throw new \Exception('Phase not started');
        }
    }

    /**
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        return $this->finished;
    }
    
    private function checkAndUpdateProgress()
    {
        // TODO
        
        // if condition is met set finished flag
        // and update other progress stuff
    }
    
    private function performTask()
    {
        // TODO
        if ($this->type == Phase::CONTROL_TEMP) {
            // call control temp on our Unit
            echo "Setting temperature to: '".$this->value."'\n";
        }else if ($this->type == Phase::ADD_INGREDIENTS){
            // ask operator to add the ingredients
            echo 'Please add the following ingredient: \''.$this->value.'\'\n"';
        }else{
            throw new \Exception('Unknown Phase type: '.$this->type);
        }
    }
}
