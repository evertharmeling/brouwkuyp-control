<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * ControlRecipe
 */
class ControlRecipe implements ExecutableInterface
{
    /**
     *
     * @var integer
     */
    protected $id;
    
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
     * Constructs
     */
    public function __construct($id = NULL)
    {
        $this->id = $id;
    }

    /**
     * Loads control recipe
     */
    public function load()
    {
        // Load
        $this->name = "test";
        $this->procedure = new Procedure(1);
        $this->procedure->load();
    }

    /**
     * Set name
     *
     * @param string $name            
     * @return MasterRecipe
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
    
    /*
     * (non-PHPdoc) @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::start()
     */
    public function start()
    {
        if (! is_null($this->procedure)) {
            if (! $this->procedure->isFinished()) {
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
     * (non-PHPdoc)
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     * @throws \Exception
     */
    public function execute()
    {
        if (! is_null($this->procedure)) {
            if (! $this->procedure->isFinished()) {
                $this->procedure->execute();
            } else {
                throw new \Exception('Procedure not started');
            }
        } else {
            throw new \Exception('No procedure for this Recipe');
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        $started = false;
        if (! is_null($this->procedure)) {
            $started = $this->procedure->isStarted();
        } else {
            $started = false;
        }
        return $started;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        $finished = false;
        if (! is_null($this->procedure)) {
            $finished = $this->procedure->isFinished();
        } else {
            $finished = false;
        }
        return $finished;
    }
}
