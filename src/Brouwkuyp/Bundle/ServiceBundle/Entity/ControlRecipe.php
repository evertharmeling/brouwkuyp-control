<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Entity;

use Brouwkuyp\Bundle\LogicBundle\Model\ControlRecipe as BaseControlRecipe;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ControlRecipe
 */
class ControlRecipe extends BaseControlRecipe
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $version;

    /**
     * @var string
     */
    protected $remarks;

    /**
     * @var ArrayCollection|Batch[]
     */
    protected $batches;

    public function __construct()
    {
        $this->batches = new ArrayCollection();
    }

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
     * Set version
     *
     * @param  integer       $version
     * @return ControlRecipe
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set remarks
     *
     * @param  string        $remarks
     * @return ControlRecipe
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @return Batch[]|ArrayCollection
     */
    public function getBatches()
    {
        return $this->batches;
    }

    /**
     * @param  Batch[]|ArrayCollection $batches
     * @return ControlRecipe
     */
    public function setBatches($batches)
    {
        $this->batches = $batches;

        return $this;
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
