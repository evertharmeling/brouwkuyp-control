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
    const TOPIC_MASHER_CURR_TEMP = 'brewery.brewhouse01.masher.curr_temp';
    const TOPIC_HLT_CURR_TEMP   = 'brewery.brewhouse01.masher.hlt.curr_temp';
    const TOPIC_MLT_CURR_TEMP   = 'brewery.brewhouse01.masher.mlt.curr_temp';
    const TOPIC_MLT_SET_TEMP    = 'brewery.brewhouse01.masher.mlt.set_temp';

    const TOPIC_BLT_CURR_TEMP   = 'brewery.brewhouse01.boiler.curr_temp';

    const TOPIC_EXT_CURR_TEMP   = 'brewery.brewhouse01.ext.curr_temp';

    const TOPIC_PUMP_SET_STATE  = 'brewery.brewhouse01.pump.set_state';
    const TOPIC_PUMP_CURR_STATE = 'brewery.brewhouse01.pump.curr_state';
    const TOPIC_PUMP_SET_MODE   = 'brewery.brewhouse01.pump.set_mode';
    const TOPIC_PUMP_CURR_MODE  = 'brewery.brewhouse01.pump.curr_mode';

    const TOPIC_BROADCAST_LOG   = 'brewery.brewhouse01.broadcast.log';
    const TOPIC_BROADCAST_DIALOG = 'brewery.brewhouse01.broadcast.dialog';

    const TYPE_S88              = 's88';
    const TYPE_TEMPERATURE      = 'temperature';
    const TYPE_PUMP             = 'pump';
    const TYPE_BROADCAST        = 'broadcast';

    /**
     * @var array
     */
    public static $typeMapping = [
        self::TOPIC_HLT_CURR_TEMP   => self::TYPE_TEMPERATURE,
        self::TOPIC_MLT_SET_TEMP    => self::TYPE_TEMPERATURE,
        self::TOPIC_MLT_CURR_TEMP   => self::TYPE_TEMPERATURE,
        self::TOPIC_BLT_CURR_TEMP   => self::TYPE_TEMPERATURE,
        self::TOPIC_EXT_CURR_TEMP   => self::TYPE_TEMPERATURE,
        self::TOPIC_MASHER_SET_TEMP => self::TYPE_TEMPERATURE,
        self::TOPIC_MASHER_CURR_TEMP => self::TYPE_TEMPERATURE,
        self::TOPIC_PUMP_SET_MODE   => self::TYPE_PUMP,
        self::TOPIC_PUMP_CURR_MODE  => self::TYPE_PUMP,
        self::TOPIC_PUMP_SET_STATE  => self::TYPE_PUMP,
        self::TOPIC_PUMP_CURR_STATE => self::TYPE_PUMP,
        self::TOPIC_BROADCAST_LOG   => self::TYPE_BROADCAST,
        self::TOPIC_BROADCAST_DIALOG => self::TYPE_BROADCAST
    ];

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var
     */
    protected $type;

    /**
     * @var string
     */
    protected $topic;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var Batch
     */
    protected $batch;

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
        return (string) sha1($this->getCreatedAt() . $this->getTopic() . $this->getValue());
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
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param  mixed $type
     * @return Log
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * @return Batch
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param  Batch $batch
     * @return Log
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;

        return $this;
    }
}
