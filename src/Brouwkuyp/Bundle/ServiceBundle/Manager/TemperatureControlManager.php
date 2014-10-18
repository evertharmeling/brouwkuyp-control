<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

abstract class TemperatureControlManager implements TemperatureControlManagerInterface
{

    abstract public function setTemperature($object, $value);
}
