<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model\Equipment;

use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;

class MLT implements EquipmentInterface
{
    /**
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
     * 
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\Equipment\EquipmentInterface::performTask()
     */
    public function performTask(Phase $phase)
    {
        if ($phase->getType() == Phase::CONTROL_TEMP) {
            $this->bcm->setMashTemperature($phase->getValue());
        } else if ($phase->getType() == Phase::ADD_INGREDIENTS) {
            echo sprintf("Operator, add the following ingredients: '%s'", $phase->getValue()) . PHP_EOL;
        } else {
            throw new \Exception('Unknown Phase type');
        }
    }
}