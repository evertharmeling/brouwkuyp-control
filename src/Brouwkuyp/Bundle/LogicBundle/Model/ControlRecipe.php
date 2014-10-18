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

    /**
     *
     */
    public function __construct()
    {
=======
    
    /**
     * 
     */
    public function __construct(){
        
>>>>>>> Added new models
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
     * Start the procedure of this recipe
     */
    public function startProcedure()
    {
    }

    public function execute()
    {
        if (! is_null($this->procedure)) {
<<<<<<< HEAD
            if (! $this->procedure->isFinished()) {
                $this->procedure->execute();
            } else {
                // Procedure not started
            }
        } else {
=======
            if(! $this->procedure->isFinished()){
                $this->procedure->execute();
            }else{
                // Procedure not started
            }
        }else{
>>>>>>> Added new models
            throw new \Exception("No procedure for this Recipe");
        }
    }

    public function stopProcedure()
    {
    }
}
