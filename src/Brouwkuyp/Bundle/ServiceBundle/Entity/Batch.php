<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Batch as BaseBatch;
use Brouwkuyp\Bundle\ServiceBundle\Doctrine\DateTime;

/**
 * Batch
 */
class Batch extends BaseBatch
{
    /**
     * 
     * @var integer
     */
    protected $id;
    
    /**
     * 
     * @var DateTime
     */
    protected $creationAt;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Batch
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set control_recipe
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe $controlRecipe
     * @return Batch
     */
    public function setControlRecipe(\Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe $controlRecipe = null)
    {
        $this->control_recipe = $controlRecipe;

        return $this;
    }

    /**
     * Get control_recipe
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe 
     */
    public function getControlRecipe()
    {
        return $this->control_recipe;
    }

    /**
     * Set master_recipe
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\MasterRecipe $masterRecipe
     * @return Batch
     */
    public function setMasterRecipe(\Brouwkuyp\Bundle\ServiceBundle\Entity\MasterRecipe $masterRecipe = null)
    {
        $this->master_recipe = $masterRecipe;

        return $this;
    }

    /**
     * Get master_recipe
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\MasterRecipe 
     */
    public function getMasterRecipe()
    {
        return $this->master_recipe;
    }
}
