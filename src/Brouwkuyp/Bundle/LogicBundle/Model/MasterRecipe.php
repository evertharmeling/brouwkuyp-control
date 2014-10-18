<?php

<<<<<<< HEAD
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/MasterRecipe.php
namespace Brouwkuyp\Bundle\LogicBundle\Model;
=======
namespace Brouwkuyp\Bundle\BrewBundle\Entity;
=======
namespace Brouwkuyp\Bundle\LogicBundle\Model;
>>>>>>> Added new models

<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/MasterRecipe.php
use Doctrine\ORM\Mapping as ORM;
>>>>>>> Renamed bundle namespaces:src/Brouwkuyp/Bundle/BrewBundle/Entity/MasterRecipe.php

=======
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/MasterRecipe.php
/**
 * MasterRecipe
 */
class MasterRecipe
{
    /**
     * @var string
     */
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/MasterRecipe.php
    protected $name;
=======
    private $name;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/MasterRecipe.php

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
