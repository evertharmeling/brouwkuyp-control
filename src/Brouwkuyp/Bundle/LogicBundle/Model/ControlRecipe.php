<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model;

use Brouwkuyp\Bundle\LogicBundle\BrewEvents;
use Brouwkuyp\Bundle\LogicBundle\Event\ControlRecipeFinishEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\ControlRecipeStartEvent;
use Brouwkuyp\Bundle\LogicBundle\Event\EventDispatcherAwareInterface;
use Brouwkuyp\Bundle\LogicBundle\Traits\EventDispatcherTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\ExecutableTrait;
use Brouwkuyp\Bundle\LogicBundle\Traits\BatchElementTrait;

/**
 * ControlRecipe
 */
class ControlRecipe implements ExecutableInterface, BatchElementInterface, EventDispatcherAwareInterface
{
    use ExecutableTrait;
    use BatchElementTrait;
    use EventDispatcherTrait;

    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var Procedure
     */
    protected $procedure;

    /**
     * Set name
     *
     * @param string $name            
     * @return ControlRecipe
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @see ExecutableInterface::start()
     * @throws \Exception
     */
    public function start()
    {
        if (is_null($this->procedure)) {
            throw new \Exception('No Procedure for this Recipe');
        }
        
        if ($this->procedure->isFinished()) {
            throw new \Exception('Procedure already finished');
        }

        $this->eventDispatcher->dispatch(BrewEvents::CONTROL_RECIPE_START, new ControlRecipeStartEvent($this));
        $this->batch->startTimer($this->name, 'start');

        $this->procedure->setEventDispatcher($this->eventDispatcher);
        $this->procedure->start();
    }

    /**
     *
     * @see ExecutableInterface::execute()
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->procedure->isFinished()) {
            $this->procedure->execute();
        } else {
            $this->eventDispatcher->dispatch(BrewEvents::CONTROL_RECIPE_FINISH, new ControlRecipeFinishEvent($this));
        }
    }

    /**
     *
     * @see ExecutableInterface::isStarted()
     */
    public function isStarted()
    {
        return $this->getProcedure()->isStarted();
    }

    /**
     *
     * @see ExecutableInterface::isFinished()
     */
    public function isFinished()
    {
        return $this->procedure->isFinished();
    }

    /**
     * Set procedure
     *
     * @param Procedure $procedure            
     * @return ControlRecipe
     */
    public function setProcedure(Procedure $procedure = null)
    {
        $this->procedure = $procedure;
        
        return $this;
    }

    /**
     * Get procedure
     *
     * @return Procedure
     */
    public function getProcedure()
    {
        return $this->procedure;
    }
}
