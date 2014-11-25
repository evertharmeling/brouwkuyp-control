<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model\Equipment;

use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;

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
        echo sprintf('MLT::performTask \'%s\': %s', $phase->getType(), $phase->getValue()) . PHP_EOL;
        if ($phase->getType() == Phase::CONTROL_TEMP) {
            $this->setHeaterTemperature($phase->getValue());
        } elseif ($phase->getType() == Phase::ADD_INGREDIENTS) {
            echo sprintf("Operator, add the following ingredients: '%s'", $phase->getValue()) . PHP_EOL;
        } else {
            throw new \Exception('Unknown Phase type');
        }
    }

    /**
     * Sets the temperature of the Heater Control Module
     *
     * @param float $setpoint
     */
    public function setHeaterTemperature($setpoint)
    {
        $this->bcm->setMashTemperature($setpoint);
    }
}
