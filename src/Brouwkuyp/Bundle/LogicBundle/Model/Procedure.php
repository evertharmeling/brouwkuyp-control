<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface;

/**
 * Procedure
 *
 * A procedure is the highest-level in the procedural control
 * hierarchy. It defines the overall strategy for making a batch.
 * It consists of an ordered set of unit procedures.
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
     * Flag that signals if we are started
     *
     * @var bool
     */
    private $started;
    
    /**
     * Flag that signals that we are finished
     *
     * @var bool
     */
    private $finished;

    /**
     */
    public function __construct()
    {
        $this->unitProcedures = new ArrayCollection();
    }

    /**
     * Loads the unitprocedures
     */
    public function load()
    {
        // Entity should load itself from a database 
        // Load UnitProcedures
        $this->unitProcedures->add(new UnitProcedure());
        $this->unitProcedures->add(new UnitProcedure());
        $this->unitProcedures->add(new UnitProcedure());
    }

    /**
     * Set name
     *
     * @param string $name            
     * @return Procedure
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
        if (! $this->started) {
            // Set flag that we are started
            $this->started = true;
            
            // Store in database that we are started
            // Entity should store itself
            
            // Start first UnitProcedure
            $this->unitProcedures->first()->start();
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     */
    public function execute()
    {
        if ($this->started) {
            // Start the next unit procedure?
            if ($this->unitProcedures->current()->isFinished()) {
                // Go to next unit procedure if possible
                if ($this->unitProcedures->next()) {
                    $this->unitProcedures->current()->start();
                } else {
                    // If last unit procedure is finished
                    // set the finished flag
                    $this->finished = true;
                }
            }
            // Execute
            if ($this->unitProcedures->current()->isStarted()) {
                // Perform unit procedure
                $this->currentUnitProcedure->execute();
            }
        } else {
            throw new \Exception('Procedure not started');
        }
    }
}
