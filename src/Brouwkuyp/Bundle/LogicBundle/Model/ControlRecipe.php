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
<<<<<<< HEAD

=======
    
>>>>>>> Added new models
    /**
     *
     * @var Procedure
     */
    protected $procedure;
<<<<<<< HEAD
<<<<<<< HEAD

    /**
     *
     */
    public function __construct()
    {
=======
    
=======

>>>>>>> Extended RecipeControl
    /**
     */
<<<<<<< HEAD
    public function __construct(){
        
>>>>>>> Added new models
=======
    public function __construct()
    {
>>>>>>> Extended RecipeControl
    }

    /**
     * Set name
     *
<<<<<<< HEAD
     * @param  string       $name
=======
     * @param string $name            
>>>>>>> Added new models
     * @return MasterRecipe
     */
    public function setName($name)
    {
        $this->name = $name;
<<<<<<< HEAD

=======
        
>>>>>>> Added new models
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
<<<<<<< HEAD
<<<<<<< HEAD
            if (! $this->procedure->isFinished()) {
                $this->procedure->execute();
            } else {
                // Procedure not started
            }
        } else {
=======
            if(! $this->procedure->isFinished()){
=======
            if (! $this->procedure->isFinished()) {
>>>>>>> Extended RecipeControl
                $this->procedure->execute();
            } else {
                // Procedure is finished
            }
<<<<<<< HEAD
        }else{
>>>>>>> Added new models
=======
        } else {
>>>>>>> Extended RecipeControl
            throw new \Exception("No procedure for this Recipe");
        }
    }

    public function stopProcedure()
    {
    }
}
