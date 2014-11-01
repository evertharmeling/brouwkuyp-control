<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * ControlRecipe
 */
class ControlRecipe
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

    public function load()
    {
        $this->name = "test";
        $procedureId = -1;
        $this->procedure = new Procedure($procedureId);
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

    /**
     * Start the procedure of this recipe
     */
    public function startProcedure()
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

    public function execute()
    {
        if (! is_null($this->procedure)) {
            if (! $this->procedure->isFinished()) {
                $this->procedure->execute();
            } else {
                // Procedure not started
            }
        } else {
            throw new \Exception("No procedure for this Recipe");
        }
    }

    public function stopProcedure()
    {
    }
}
