<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
abstract class BrewControlManager implements BrewControlManagerInterface
{
    /**
     * @param  float $value
     * @return mixed
     */
    abstract public function setMashTemperature($value);
}
