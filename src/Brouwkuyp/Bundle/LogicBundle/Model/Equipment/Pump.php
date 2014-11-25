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
    const STATE_AUTOMATIC   = 'automatic';

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
            self::STATE_OFF,
            self::STATE_AUTOMATIC
        ];
    }
}
