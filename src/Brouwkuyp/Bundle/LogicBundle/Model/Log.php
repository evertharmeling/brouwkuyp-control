<?php

<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/Log.php
namespace Brouwkuyp\Bundle\LogicBundle\Model;
=======
namespace Brouwkuyp\Bundle\BrewBundle\Entity;
>>>>>>> Renamed bundle namespaces:src/Brouwkuyp/Bundle/BrewBundle/Entity/Log.php

/**
 * Log
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class Log
{
    /**
     * @var string
     */
    protected $topic;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/Log.php
     * @return \DateTime
=======
     * Get id
     *
     * @return integer
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/Log.php
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/Log.php
     * @param  \DateTime $createdAt
=======
     * Set topic
     *
     * @param  string $topic
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/Log.php
     * @return Log
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/Log.php
=======
     * Get topic
     *
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/Log.php
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/Log.php
     * @param  string $topic
=======
     * Set value
     *
     * @param  string $value
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/Log.php
     * @return Log
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/Log.php
=======
     * Get value
     *
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/Log.php
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/Log.php
     * @param  string $value
=======
     * Set createdAt
     *
     * @param  \DateTime $createdAt
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/Log.php
     * @return Log
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
<<<<<<< HEAD:src/Brouwkuyp/Bundle/LogicBundle/Model/Log.php
=======

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
>>>>>>> Ran php-cs-fixer:src/Brouwkuyp/Bundle/BrewBundle/Entity/Log.php
}
