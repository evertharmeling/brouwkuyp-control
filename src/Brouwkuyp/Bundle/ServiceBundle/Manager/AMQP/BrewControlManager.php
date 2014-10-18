<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP;

use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManager as BaseBrewControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\TemperatureMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BrewControlManager extends BaseBrewControlManager
{
    // @todo dynamic route, because current class does not have knowledge about the whole infrastructure
    const ROUTE_MASHER_SET_TEMP = 'brewery.brewhouse01.masher.set_temp';

    /**
     * @var Manager
     */
    protected $amqpManager;

    /**
     * @param Manager $amqpManager
     */
    public function __construct(Manager $amqpManager)
    {
        $this->amqpManager = $amqpManager;
    }

    /**
     * @param  float      $value
     * @return mixed|void
     */
    public function setMashTemperature($value)
    {
        $this->amqpManager->publish(new TemperatureMessage($value), self::ROUTE_MASHER_SET_TEMP);
    }
}
