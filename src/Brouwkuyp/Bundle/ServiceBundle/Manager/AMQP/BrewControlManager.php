<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP;

use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message\PumpModeMessage;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message\PumpStateMessage;
use Brouwkuyp\Bundle\ServiceBundle\Model\AMQP\Message\TemperatureMessage;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BrewControlManager implements BrewControlManagerInterface
{
    // @todo dynamic route, because current class does not have knowledge about the whole infrastructure
    const ROUTE_MASHER_SET_TEMP     = 'brewery.brewhouse01.masher.set_temp';
    const ROUTE_MASHER_HLT_SET_TEMP = 'brewery.brewhouse01.masher.hlt.set_temp';
    const ROUTE_PUMP_SET_MODE       = 'brewery.brewhouse01.pump.set_mode';
    const ROUTE_PUMP_SET_STATE      = 'brewery.brewhouse01.pump.set_state';

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
     * @param  float $value
     * @return bool
     */
    public function setMashTemperature($value)
    {
        return $this->amqpManager->publish(new TemperatureMessage($value), self::ROUTE_MASHER_SET_TEMP);
    }

    /**
     * @param float $value
     * @return bool
     */
    public function setHLTTemperature($value)
    {
        return $this->amqpManager->publish(new TemperatureMessage($value), self::ROUTE_MASHER_HLT_SET_TEMP);
    }

    /**
     * @param  string $value
     * @return bool
     */
    public function setPumpMode($value)
    {
        return $this->amqpManager->publish(new PumpModeMessage($value), self::ROUTE_PUMP_SET_MODE);
    }

    /**
     * @param  string $value
     * @return bool
     */
    public function setPumpState($value)
    {
        return $this->amqpManager->publish(new PumpStateMessage($value), self::ROUTE_PUMP_SET_STATE);
    }
}
