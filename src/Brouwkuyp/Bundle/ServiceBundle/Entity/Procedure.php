<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Procedure as BaseProcedure;

/**
 * Procedure
 */
class Procedure extends BaseProcedure
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
