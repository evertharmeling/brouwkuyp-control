<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model\Equipment;

use Brouwkuyp\Bundle\LogicBundle\Model\Phase;

interface EquipmentInterface 
{
    public function performTask(Phase $phase);
}