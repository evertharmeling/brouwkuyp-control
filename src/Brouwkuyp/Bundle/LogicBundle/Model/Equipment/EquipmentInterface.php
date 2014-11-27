<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model\Equipment;

use Brouwkuyp\Bundle\LogicBundle\Model\Phase;

/**
 * Interface for controlling equipment.
 * Every equipment
 * knows how to handle a Phase for itś own Unit.
 */
interface EquipmentInterface
{
    /**
     * Perform the task that is needed for the given Phase
     * on the corresponding Unit.
     *
     * @param Phase $phase
     */
    public function performTask(Phase $phase);
}
