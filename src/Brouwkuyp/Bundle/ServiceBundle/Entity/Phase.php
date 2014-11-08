<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Phase as BasePhase;

/**
 * Phase
 */
class Phase extends BasePhase
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Brouwkuyp\Bundle\ServiceBundle\Entity\Operation
     */
    protected $operation;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Phase
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
     * Set operation
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\Operation $operation
     * @return Phase
     */
    public function setOperation(\Brouwkuyp\Bundle\ServiceBundle\Entity\Operation $operation = null)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\Operation 
     */
    public function getOperation()
    {
        return $this->operation;
    }
    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $value;


    /**
     * Set type
     *
     * @param string $type
     * @return Phase
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return Phase
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }
}
