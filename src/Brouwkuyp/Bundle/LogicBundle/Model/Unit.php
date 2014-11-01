<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * Unit
 */
class Unit
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
     * Constructs
     * 
     * @param integer $id
     */
    public function __construct($id){
        $this->id = $id;
    }
    
    /**
     * Sets the name of the unit
     * 
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }
    
    /**
     * Gets the name of the unit
     * 
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * Gets the id of the unit
     * 
     * @return integer
     */
    public function getId(){
        return $this->id;
    }
}
