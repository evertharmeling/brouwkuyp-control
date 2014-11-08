<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formula
 */
class Formula
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe
     */
    private $controlrecipe;


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
     * @return Formula
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
     * Set controlrecipe
     *
     * @param \Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe $controlrecipe
     * @return Formula
     */
    public function setControlrecipe(\Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe $controlrecipe = null)
    {
        $this->controlrecipe = $controlrecipe;

        return $this;
    }

    /**
     * Get controlrecipe
     *
     * @return \Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe 
     */
    public function getControlrecipe()
    {
        return $this->controlrecipe;
    }
}
