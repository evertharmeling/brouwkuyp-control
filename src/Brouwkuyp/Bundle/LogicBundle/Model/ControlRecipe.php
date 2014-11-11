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
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::start()
     * @throws \Exception
     */
    public function start()
    {
        echo " ControlRecipe::start 1\n";
        if (!is_null($this->procedure)) {
            if (!$this->procedure->isFinished()) {
                $this->procedure->start();
            } else {
                throw new \Exception('Procedure already finished');
            }
        } else {
            throw new \Exception('No Procedure for this Recipe');
        }
    }

    /**
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     * @throws \Exception
     */
    public function execute()
    {
        echo " ControlRecipe::execute \n";
        if (!is_null($this->procedure)) {
            if (!$this->procedure->isFinished()) {
                $this->procedure->execute();
            } else {
                // procedure finished!
                // TODO
            }
        } else {
            throw new \Exception('No procedure for this Recipe');
        }
    }

    /**
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        if (!is_null($this->getProcedure())) {
            return $this->getProcedure()->isStarted();
        }
        
        return false;
    }

    /**
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        if (!is_null($this->procedure)) {
            return $this->procedure->isFinished();
        }
        
        return false;
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
