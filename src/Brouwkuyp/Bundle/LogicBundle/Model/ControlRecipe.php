<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * ControlRecipe
 */
class ControlRecipe implements ExecutableInterface
{
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var Procedure
     */
    protected $procedure;

    /**
     * Set name
     *
     * @param string $name            
     * @return ControlRecipe
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
     *
     * @see ExecutableInterface::start()
     * @throws \Exception
     */
    public function start()
    {
        echo 'ControlRecipe::start' . PHP_EOL;
        if (is_null($this->procedure)) {
            throw new \Exception('No Procedure for this Recipe');
        }
        
        if ($this->procedure->isFinished()) {
            throw new \Exception('Procedure already finished');
        }
        
        $this->procedure->start();
    }

    /**
     *
     * @see ExecutableInterface::execute()
     * @throws \Exception
     */
    public function execute()
    {       
        if (!$this->procedure->isFinished()) {
            $this->procedure->execute();
        } else {
            echo 'ControlRecipe is done' . PHP_EOL;
        }
    }

    /**
     *
     * @see ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        return $this->getProcedure()->isStarted();
    }

    /**
     *
     * @see ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        return $this->procedure->isFinished();
    }

    /**
     * Set procedure
     *
     * @param Procedure $procedure            
     * @return ControlRecipe
     */
    public function setProcedure(Procedure $procedure = null)
    {
        $this->procedure = $procedure;
        
        return $this;
    }

    /**
     * Get procedure
     *
     * @return Procedure
     */
    public function getProcedure()
    {
        return $this->procedure;
    }
}
