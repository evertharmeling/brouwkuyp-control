<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\Traits\ExecutableTrait;

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
        }
    }

    /**
     * Executes stage
     */
    public function execute()
    {
        echo "     Phase::execute: '" . $this->name . "'\n";
        if ($this->started) {
            throw new \Exception('Phase not started');
        }

        if (!$this->finished) {
            $this->checkAndUpdateProgress();
            $this->performTask();
        }
    }

    private function checkAndUpdateProgress()
    {
        // @TODO

        // if condition is met set finished flag
        // and update other progress stuff
    }

    /**
     * Performs the tasks according to the phase
     *
     * @throws \Exception
     */
    private function performTask()
    {
        // @TODO
        switch ($this->type) {
            case self::CONTROL_TEMP:
                // call control temp on our Unit
                echo sprintf("Setting temperature to: '%s'", $this->value) . PHP_EOL;
                break;
            case self::ADD_INGREDIENTS:
                // ask operator to add the ingredients
                echo sprintf("Please add the following ingredient: '%s'", $this->value) . PHP_EOL;
                break;
            default:
                throw new \Exception('Unknown Phase type: '.$this->type);
        }
    }
}
