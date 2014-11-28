<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * BaseCommand
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
abstract class BaseCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Because the EntityManager gets closed when there's an error, it needs to
     * be created again
     *
     * @return EntityManager
     * @throws ORMException
     */
    protected function getEntityManager()
    {
        if (!$this->em) {
            $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        }

        if (!$this->em->isOpen()) {
            $this->em = $this->em->create($this->em->getConnection(), $this->em->getConfiguration());
        }

        return $this->em;
    }

    /**
     * Flushes the EntityManager
     */
    protected function flush()
    {
        try {
            $this->getEntityManager()->flush();
            $this->getEntityManager()->clear();
        } catch (\Exception $e) {
            // in case more than one message is sent and logged, which results in a primary key constraint
        }
    }

    /**
     * Returns the memory usage in MB's
     *
     * @return float
     */
    protected function getMemoryUsage()
    {
        return round(memory_get_usage() / 1024 / 1024, 2);
    }
}
