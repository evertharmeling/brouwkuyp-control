<?php

namespace Brouwkuyp\Bundle\ServiceBundle\EventListener;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * @author Evert Harmeling <evert.harmeling@freshheads.com>
 */
class EntitySubscriber implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist'
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof Log) {
            if (!$object->getType()) {
                if (isset(Log::$typeMapping[$object->getTopic()])) {
                    $object->setType(Log::$typeMapping[$object->getTopic()]);
                } else {
                    $object->setType(Log::TYPE_S88);
                }
            }
        }
    }
}
