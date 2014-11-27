<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
abstract class BrewControlManager implements BrewControlManagerInterface
{
    /**
     * @param  float $value
     * @return bool
     */
    abstract public function setMashTemperature($value);

    /**
     * @param  string $value
     * @return bool
     */
    abstract public function setPumpState($value);

    /**
     * @param  string $value
     * @return bool
     */
    abstract public function setPumpMode($value);
}
