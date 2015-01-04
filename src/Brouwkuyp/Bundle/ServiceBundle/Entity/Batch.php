<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\Batch as BaseBatch;
use Brouwkuyp\Bundle\ServiceBundle\Doctrine\DateTime;

/**
 * Batch
 */
class Batch extends BaseBatch
{
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var DateTime
     */
    protected $createdAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Batch
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function getRouteParams()
    {
        return [
            'id' => $this->getId()
        ];
    }
}
