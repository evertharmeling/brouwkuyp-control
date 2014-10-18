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
    public function __construct(){
        
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
    }

    public function execute()
    {
        if (! is_null($this->procedure)) {
            if(! $this->procedure->isFinished()){
                $this->procedure->execute();
            }else{
                // Procedure not started
            }
        }else{
            throw new \Exception("No procedure for this Recipe");
        }
    }

    public function stopProcedure()
    {
    }
}
