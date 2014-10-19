<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * UnitProcedure
 */
class UnitProcedure implements ExecutableInterface
{
    /**
     * @var string
     */
    protected $name;

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
     * (non-PHPdoc)
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::start()
     */
    public function start()
    {
        
    }
    
    /**
     * (non-PHPdoc)
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     */
    public function execute()
    {
        
    }
}
