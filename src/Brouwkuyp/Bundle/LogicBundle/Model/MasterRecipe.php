<?php

<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/MasterRecipe.php
namespace Brouwkuyp\Bundle\LogicBundle\Model;
=======
namespace Brouwkuyp\Bundle\BrewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
>>>>>>> Renamed bundle namespaces:src/Brouwkuyp/Bundle/BrewBundle/Entity/MasterRecipe.php

/**
 * MasterRecipe
 */
class MasterRecipe
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
}
