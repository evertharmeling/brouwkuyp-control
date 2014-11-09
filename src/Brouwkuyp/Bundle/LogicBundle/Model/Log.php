<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * Log
 */
class Log
{
    // @todo move
    const TOPIC_HLT_CURR_TEMP = 'brewery.brewhouse01.masher.hlt.curr_temp';
    const TOPIC_MLT_CURR_TEMP = 'brewery.brewhouse01.masher.mlt.curr_temp';
    const TOPIC_BLT_CURR_TEMP = 'brewery.brewhouse01.masher.blt.curr_temp';

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

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return sha1($this->getCreatedAt()->format('U') . $this->getTopic());
    }
}
