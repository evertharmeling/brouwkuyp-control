<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @var ControlRecipe
     */
    protected $controlRecipe;

    /**
     * Collection of UnitProcedure
     *
     * @var ArrayCollection
     */
    protected $unitProcedures;

    /**
     */
    public function __construct()
    {
        $this->unitProcedures = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param  string       $name
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

    /**
     * Set ControlRecipe
     *
     * @param ControlRecipe $controlRecipe
     * @return Procedure
     */
    public function setControlRecipe(ControlRecipe $controlRecipe = null)
    {
        $this->controlRecipe = $controlRecipe;

        return $this;
    }

    /**
     * Get controlrecipe
     *
     * @return ControlRecipe
     */
    public function getControlRecipe()
    {
        return $this->controlRecipe;
    }

    /**
     * Add UnitProcedure
     *
     * @param UnitProcedure $unitProcedure
     * @return Procedure
     */
    public function addUnitprocedure(UnitProcedure $unitProcedure)
    {
        $this->unitProcedures[] = $unitProcedure;

        return $this;
    }

    /**
     * Remove UnitProcedure
     *
     * @param UnitProcedure $unitProcedure
     */
    public function removeUnitProcedure(UnitProcedure $unitProcedure)
    {
        $this->unitProcedures->removeElement($unitProcedure);
    }

    /**
     * Get UnitProcedure
     *
     * @return ArrayCollection
     */
    public function getUnitProcedures()
    {
        return $this->unitProcedures;
    }

    /**
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::start()
     */
    public function start()
    {
        echo "Procedure::start \n";
        echo "unitProcedure count: ".$this->unitProcedures->count()." \n";
             
        if (! $this->started) {
            // Set flag that we are started
            $this->started = true;
            
            // Start first UnitProcedure
            if ($this->getUnitProcedures()->count()) {
                $this->getUnitProcedures()->first()->start();
            }
        }
    }

    /**
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     */
    public function execute()
    {
        echo "Procedure::execute \n";
        
        if ($this->isStarted()) {
            if (!$this->getCurrentUnitProcedure()) {
                $this->finished = true;
                return;
            }

            // Start the next unit procedure?
            if ($this->getCurrentUnitProcedure()->isFinished()) {
                // Go to next unit procedure if possible
                if ($this->getUnitProcedures()->next()) {
                    $this->getCurrentUnitProcedure()->start();

                    // Execute
                    if ($this->getCurrentUnitProcedure()->isStarted()) {
                        // Perform unit procedure
                        $this->$this->getCurrentUnitProcedure()->execute();
                    }
                } else {
                    // If last unit procedure is finished
                    // set the finished flag
                    $this->finished = true;
                }
            }
        } else {
            throw new \Exception('Procedure not started');
        }
    }

    /**
     * Returns started state
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isStarted()
     * @return bool
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * Returns finished state
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::isFinished()
     * @return bool
     */
    public function isFinished()
    {
        echo "Procedure::isFinished \n";
        return $this->finished;
    }

    /**
     * @return UnitProcedure|false
     */
    public function getCurrentUnitProcedure()
    {
        return $this->getUnitProcedures()->current();
    }
}
