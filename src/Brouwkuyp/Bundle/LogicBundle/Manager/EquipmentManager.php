<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\EquipmentInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\MLT;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Unit;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;

class EquipmentManager
{
    /**
     * @var BrewControlManagerInterface
     */
    private $brewControlManager;

    /**
     * @var Manager
     */
    private $amqpManager;

    /**
     * @var MLT
     */
    private $mlt;

    /**
     * Constructs the EquipmentManager
     *
     * @param BrewControlManagerInterface $brewControlManager
     * @param Manager                     $amqpManager
     */
    public function __construct(BrewControlManagerInterface $brewControlManager, Manager $amqpManager)
    {
        $this->brewControlManager = $brewControlManager;
        $this->amqpManager = $amqpManager;
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
        $equipment = null;
        // TODO: cache units and equipment
        // TODO: Unit can have multiple equipment
        if ($unit->getName() == Unit::TYPE_MASHER) {
            if (is_null($this->mlt)) {
                $this->mlt = new MLT($this->brewControlManager, $this->amqpManager);
            }
            $equipment = $this->mlt;
        }

        return $equipment;
    }
}
