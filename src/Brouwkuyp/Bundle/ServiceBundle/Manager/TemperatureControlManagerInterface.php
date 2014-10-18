<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

interface TemperatureControlManagerInterface
{
    /**
     * @param TemperatureInterface $object
     * @param $value
     * @return mixed
     */
    public function setTemperature($object, $value);
}
