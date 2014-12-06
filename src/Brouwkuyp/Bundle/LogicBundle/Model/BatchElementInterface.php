<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

interface BatchElementInterface
{
    /**
     * Starts the element of a recipe for a given batch
     * 
     * @param Batch $batch
     */
    public function setBatch(Batch $batch);
    
    /**
     * Gets the batch that this element belongs to,
     * 
     * @return Batch
     */
    public function getBatch();
}