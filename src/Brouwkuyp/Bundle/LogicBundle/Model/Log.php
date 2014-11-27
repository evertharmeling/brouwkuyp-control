<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\ServiceBundle\Doctrine\DateTime;

/**
 * Log
 */
class Log
{
    // @todo move
    const TOPIC_MASHER_SET_TEMP = 'brewery.brewhouse01.masher.set_temp';
    const TOPIC_HLT_CURR_TEMP   = 'brewery.brewhouse01.masher.hlt.curr_temp';
    const TOPIC_MLT_CURR_TEMP   = 'brewery.brewhouse01.masher.mlt.curr_temp';
    const TOPIC_MLT_SET_TEMP    = 'brewery.brewhouse01.masher.mlt.set_temp';

    const TOPIC_BLT_CURR_TEMP   = 'brewery.brewhouse01.boiler.curr_temp';

    const TOPIC_PUMP_CURR_STATE = 'brewery.brewhouse01.pump.curr_state';
    const TOPIC_PUMP_CURR_MODE  = 'brewery.brewhouse01.pump.curr_mode';

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
     * Constructs the object
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) sha1($this->getCreatedAt() . $this->getTopic());
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param  DateTime $createdAt
     * @return Log
     */
    public function setCreatedAt(DateTime $createdAt)
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
