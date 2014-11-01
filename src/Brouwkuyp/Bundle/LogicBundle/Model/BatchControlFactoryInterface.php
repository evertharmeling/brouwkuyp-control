<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

/**
 * BatchControlFactoryInterface
 *
 */
interface BatchControlFactoryInterface
{
    /**
     * @return \ControlRecipe
     */
    public function createControlRecipe();
    
    /**
     * @return \Procedure
     */
    public function createProcedure();
    
    /**
     * @return \UnitProcedure
     */
    public function createUnitProcedure();
    
    /**
     * @return \Operation
     */
    public function createOperation();
    
    /**
     * @return \Phase
     */
    public function createPhase();
    
}
