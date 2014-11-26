<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model\Equipment;

/**
 * Pump
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class Pump
{
    const STATE_ON          = 'on';
    const STATE_OFF         = 'off';

    const MODE_AUTOMATIC    = 'automatic';
    const MODE_MANUAL       = 'manual';

    /**
     * Returns possible pump states
     *
     * @return array
     */
    public static function getPossibleStates()
    {
        return [
            self::STATE_ON,
            self::STATE_OFF
        ];
    }

    /**
     * Returns possible pump modes
     *
     * @return array
     */
    public static function getPossibleModes()
    {
        return [
            self::MODE_AUTOMATIC,
            self::MODE_MANUAL
        ];
    }
}
