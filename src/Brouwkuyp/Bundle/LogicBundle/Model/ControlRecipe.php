<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * ControlRecipe
 */
class ControlRecipe
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
     *
     */
    public function __construct()
    {

    }

    /**
     * Set name
     *
     * @param  string       $name
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
     * Set Procedure for this Recipe
     *
     * @param Procedure $proc            
     * @throws \Exception
     */
    public function setProcedure(Procedure $proc)
    {
        if (! is_null($this->procedure)) {
            throw new \Exception("Recipe already has a Procedure");
        } else {
            $this->procedure = $proc;
        }
    }

    /**
     *
     * @return \Brouwkuyp\Bundle\LogicBundle\Model\Procedure
     */
    public function getProcedure()
    {
        return $this->procedure;
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
