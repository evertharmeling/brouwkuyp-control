<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
<<<<<<< HEAD
=======
use Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface;
>>>>>>> Added new models

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
<<<<<<< HEAD

=======
    
>>>>>>> Added new models
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

    public function execute()
    {
<<<<<<< HEAD

=======
        
>>>>>>> Added new models
    }
}
