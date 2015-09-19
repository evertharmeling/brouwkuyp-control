<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
interface BrewControlManagerInterface
{
    /**
     * @param  float $value
     * @return bool
     */
    public function setMashTemperature($value);

    /**
     * @param  float $value
     * @return bool
     */
    public function setHLTTemperature($value);

    /**
     * @param  string $value
     * @return bool
     */
    public function setPumpState($value);

    /**
     * @param  string $value
     * @return bool
     */
    public function setPumpMode($value);
}
