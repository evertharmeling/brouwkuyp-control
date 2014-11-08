<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Manager;

use Brouwkuyp\Bundle\LogicBundle\Manager\BatchControlFactory as AbstractBatchControlFactory;
/**
 * 
 */
class DoctrineBatchControlFactory extends AbstractBatchControlFactory
{
    /**
     * EntityManager
     * 
     * @var \EntityManager
     */
    private $entityManager;
    
    /**
     * @param \EntityManager $em
     */
    public function __construct($em)
    {
        $this->entityManager = $em;
    }
    
    public function loadControlRecipe($id)
    {
        /*$recipe = $this->entityManager
         ->getRepository('ServiceBundle:ControlRecipe')
        ->find($id);
        */
        $recipe = $this->entityManager
        ->getRepository('Brouwkuyp\Bundle\ServiceBundle\Entity\ControlRecipe')
        ->find($id);
        
        return $recipe;
    }
}
