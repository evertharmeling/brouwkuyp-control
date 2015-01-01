<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\EquipmentInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\MLT;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Unit;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EquipmentManager
{
    /**
     * @var MLT
     */
    private $mlt;

    /**
     * @param MLT $mlt
     */
    public function __construct(MLT $mlt)
    {
        $this->mlt = $mlt;
    }

    /**
     * Performs the Task needed for the given phase
     *
     * @param Phase $phase
     */
    public function performTaskFor(Phase $phase)
    {
        /** @var EquipmentInterface $equipment */
        $equipment = $this->getEquipmentOf($phase->getOperation()->getUnitProcedure()->getUnit());
        $equipment->performTask($phase);
    }

    /**
     * @param  Unit               $unit
     * @return EquipmentInterface
     */
    private function getEquipmentOf(Unit $unit)
    {
        // TODO: cache units and equipment
        // TODO: Unit can have multiple equipment
        if ($unit->getName() == Unit::TYPE_MASHER) {
            return $this->mlt;
        }
    }
}
