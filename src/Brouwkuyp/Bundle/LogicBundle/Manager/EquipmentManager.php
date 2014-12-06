<?php

namespace Brouwkuyp\Bundle\LogicBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\EquipmentInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\MLT;
use Brouwkuyp\Bundle\LogicBundle\Model\Equipment\Unit;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;

class EquipmentManager
{
    /**
     *
     * @var BrewControlManagerInterface
     */
    private $bcm;
    
    /**
     * Manager
     * @var Manager
     */
    private $am;
    
    /**
     * MLT
     * @var MLT 
     */
    private $mlt;

    /**
     * Constructs the EquipmentManager
     * 
     * @param BrewControlManagerInterface $bcm
     * @param Manager $am
     */
    public function __construct(BrewControlManagerInterface $bcm, Manager $am)
    {
        $this->bcm = $bcm;
        $this->am = $am;
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
     * @param  Unit               $unit
     * @return EquipmentInterface
     */
    private function getEquipmentOf(Unit $unit)
    {
        $equipment = null;
        // TODO: cache units and equipment
        // TODO: Unit can have multiple equipment
        if ($unit->getName() == Unit::TYPE_MASHER) {
            if(is_null($this->mlt))
            {
                $this->mlt = new MLT($this->bcm, $this->am);
            }
            $equipment = $this->mlt;
        }

        return $equipment;
    }
}
