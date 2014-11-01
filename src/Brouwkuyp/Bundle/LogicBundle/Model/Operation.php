<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * Operation
 * 
 * An operation is an ordered set of phases carried to completion 
 * within a single unit. Operations usually involve taking the 
 * material being processed through some type of physical, chemical,
 * or biological change. Like unit procedures, the standard presumes 
 * only one operation is active on a particular unit at a time.
 */
class Operation implements ExecutableInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Set name
     *
     * @param string $name
     * @return Operation
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
}
