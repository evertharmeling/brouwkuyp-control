<?php

namespace Brouwkuyp\Bundle\LogicBundle\Model\Equipment;

use Brouwkuyp\Bundle\LogicBundle\BrewEvents;
use Brouwkuyp\Bundle\LogicBundle\Event\PhaseTemperatureReachedEvent;
use Brouwkuyp\Bundle\LogicBundle\Model\Log;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MLT implements EquipmentInterface
{
    /**
     * @var BrewControlManagerInterface
     */
    private $brewControlManager;

    /**
     * @var Manager
     */
    private $amqpManager;

    /**
     * Last Temperature
     * @var integer
     */
    private $lastTemp;

    /**
     * @param BrewControlManagerInterface $brewControlManager
     * @param Manager $amqpManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(BrewControlManagerInterface $brewControlManager, Manager $amqpManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->brewControlManager = $brewControlManager;
        $this->amqpManager = $amqpManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     *
     * @see \Brouwkuyp\Bundle\LogicBundle\Model\Equipment\EquipmentInterface::performTask()
     */
    public function performTask(Phase $phase)
    {
        if ($phase->getType() == Phase::CONTROL_TEMP) {
            $this->setHeaterTemperature($phase->getValue());
        } elseif ($phase->getType() == Phase::REACH_TEMP) {
            $this->startReceiving();

            $this->amqpManager->wait();
            $this->amqpManager->receive();
            if ($this->getCurrentTemperature() > $phase->getValue()) {
                $this->eventDispatcher->dispatch(BrewEvents::PHASE_TEMPERATURE_REACHED, new PhaseTemperatureReachedEvent($phase));

                $phase->setFinished();
            }
        }
    }

    /**
     * Sets the temperature of the Heater Control Module
     *
     * @param float $setpoint
     */
    public function setHeaterTemperature($setpoint)
    {
        $this->brewControlManager->setMashTemperature($setpoint);
    }

    /**
     * Gets the current temperature of the MLT.
     */
    public function getCurrentTemperature()
    {
        return $this->lastTemp;
    }

    /**
     * @param $receivedTemp
     */
    private function setCurrentTemperature($receivedTemp)
    {
        $this->lastTemp = $receivedTemp;
    }

    private function startReceiving()
    {
        $mlt = $this;
        // TODO: refactor want dit hoort niet in logic thuis, needs to be handled by 'consume' thread / process
        $callback = function (AMQPMessage $msg) use ($mlt) {

            $topic = $msg->delivery_info['routing_key'];
            $value = $msg->body;

            $mlt->setCurrentTemperature($value);

            echo sprintf("Message received: %s: %s : %s",
                            (new \DateTime())->format('H:i:s'),
                            $topic,
                            $value
                    ) . PHP_EOL;
        };

        $this->amqpManager->consume($callback, Log::TOPIC_MLT_CURR_TEMP);
    }
}
