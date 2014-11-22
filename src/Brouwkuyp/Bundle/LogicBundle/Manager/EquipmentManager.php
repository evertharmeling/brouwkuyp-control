<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Unit;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\MLT;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\EquipmentInterface;

class EquipmentManager
{
    /**
     *
     * @var BrewControlManagerInterface
     */
    private $bcm;

    /**
     *
     * @param BrewControlManagerInterface $bcm            
     */
    public function __construct(BrewControlManagerInterface $bcm)
    {
        $this->bcm = $bcm;
    }

    /**
     * Performs the Task needed for the given PHase
     * 
     * @param Phase $phase
     */
    public function performTaskFor(Phase $phase)
    {
        /** @var EquipmentInterface */
        $equipment = $this->getEquipmentOf($phase->getOperation()->getUnitProcedure()->getUnit());
        $equipment->performTask($phase);
    }

    /**
     * 
     * @param Unit $unit
     * @return EquipmentInterface
     */
    private function getEquipmentOf(Unit $unit)
    {
        $equipment = NULL;
        // TODO: cache units and equipment
        // TODO: Unit can have multiple equipment
        if ($unit->getName() == Unit::TYPE_MASHER) {
            $equipment = new MLT($this->bcm);
        }
        return $equipment;
    }
}