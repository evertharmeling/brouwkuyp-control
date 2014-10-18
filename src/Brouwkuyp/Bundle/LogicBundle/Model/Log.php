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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param  \DateTime $createdAt
     * @return Log
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param  string $topic
     * @return Log
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  string $value
     * @return Log
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
