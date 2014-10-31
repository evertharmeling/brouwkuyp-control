<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface;

/**
 * Procedure
 */
class Procedure implements ExecutableInterface
{
    /**
     *
     * @var string
     */
    protected $name;

    /**
     * Collection of UnitProcedure
     *
     * @var ArrayCollection
     */
    protected $unitProcedures;
    
    /**
     * Current active UnitProcedure
     * 
     * @var UnitProcedure
     */
    protected $currentUnitProcedure;
    
    /**
     * Flag that says if we are already started
     * 
     * @var bool
     */
    private $started;

    public function __construct()
    {
        $this->unitProcedures = new ArrayCollection();
        $this->unitProcedures->add(new UnitProcedure());
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

    public function start()
    {
        if(!$this->started){
            // Set flag that we are started
            $this->started = true;
            
            // Store in database that we are started
            
            // Start first UnitProcedure
            $this->currentUnitProcedure = $this->unitProcedures->first();
            $this->currentUnitProcedure->start();
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     */
    public function execute()
    {
        if($this->started){
            // Perform the current unit procedure
            if($this->currentUnitProcedure->isFinished()){
                // Go to next unit procedure
                
                // If last unit procedure is finished
                // set the finished flag
            }
            if($this->currentUnitProcedure->isStarted()){
                // Perform unit procedure
                $this->currentUnitProcedure->execute();
            }
        }else{
            throw new \Exception('Procedure not started');
        }
    }
}
