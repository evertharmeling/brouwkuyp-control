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
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::start()
     * @throws \Exception
     */
    public function start()
    {
        if (!is_null($this->getProcedure())) {
            if (!$this->getProcedure()->isFinished()) {
                $this->getProcedure()->start();
            } else {
                throw new \Exception('Procedure already finished');
            }
        } else {
            throw new \Exception('No Procedure for this Recipe');
        }
    }

    /**
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     * @throws \Exception
     */
    public function execute()
    {
        if (!is_null($this->getProcedure())) {
            if (!$this->getProcedure()->isFinished()) {
                $this->getProcedure()->execute();
            } else {
                // procedure finished!
            }
        } else {
            throw new \Exception('No procedure for this Recipe');
        }
    }

    /**
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
