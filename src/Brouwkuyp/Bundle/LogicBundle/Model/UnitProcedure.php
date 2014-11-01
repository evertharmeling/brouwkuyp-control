<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * UnitProcedure
 *
 * A unit procedure is an ordered set of operations that is carried
 * to completion on a single unit. That is, a unit procedure is a
 * contiguous production sequence acting on one and only one unit.
 * Only one unit procedure is allowed to be active on a unit at any time.
 * Multiple unit procedures can run concurrently as part of the same
 * procedure, as long as they are active on different units.
 */
class UnitProcedure implements ExecutableInterface
{
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     * Collection of Operations
     *
     * @var ArrayCollection
     */
    protected $operations;
    
    /**
     * Unit that is controlled by this procedure
     * 
     * @var Unit
     */
    protected $unit;

    /**
     */
    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }
    
    /**
     * 
     */
    public function load()
    {
        // Entity should load itself from a database
        // Load operations
        $this->operations->add(new Operation(-1));
        $this->operations->add(new Operation(-1));
        $this->operations->add(new Operation(-1));
        
        $this->unit = new Unit(-1);
    }

    /**
     * Set name
     *
     * @param string $name            
     * @return UnitProcedure
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
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::start()
     */
    public function start()
    {
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\ExecutableInterface::execute()
     */
    public function execute()
    {
    }
}
