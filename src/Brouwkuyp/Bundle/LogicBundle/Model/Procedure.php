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

    public function __construct()
    {
        $this->unitProcedures = new ArrayCollection();
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

    public function execute()
    {
        
    }
}
