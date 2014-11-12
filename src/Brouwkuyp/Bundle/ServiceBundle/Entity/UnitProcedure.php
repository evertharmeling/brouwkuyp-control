<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure as BaseUnitProcedure;

/**
 * UnitProcedure
 */
class UnitProcedure extends BaseUnitProcedure
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
