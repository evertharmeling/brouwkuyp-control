<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

class AMQPTemperatureControlManager extends TemperatureControlManager
{
    const TOPIC_MASHER_SET_TEMP     = 'brewery/brewhouse01/masher/set_temp';

    public function setTemperature($object, $value)
    {
        $class = new \ReflectionClass(get_class($object));
        if ($class->implementsInterface('IInterface')) {

        }
    }

}
