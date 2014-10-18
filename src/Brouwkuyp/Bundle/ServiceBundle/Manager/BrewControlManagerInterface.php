<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
interface BrewControlManagerInterface
{
    /**
     * @param float $value
     */
    public function setMashTemperature($value);
}
