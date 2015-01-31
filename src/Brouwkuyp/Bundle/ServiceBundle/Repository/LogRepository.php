<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Repository;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * LogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LogRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getBaseQueryBuilder()
    {
        $qb = $this->createQueryBuilder('l')
            ->orderBy('l.createdAt', 'ASC')
        ;

        return $qb;
    }

    /**
     * @return array
     */
    public function findForCurrentRecipe()
    {
        $qb = $this->getBaseQueryBuilder()
            ->andWhere('DATE(l.createdAt) = :date')
            ->setParameter('date', (new \DateTime())->format('Y-m-d'))
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param  integer $id
     * @return array
     */
    public function findForGraphAndBatchId($id)
    {
        $qb = $this->getBaseQueryBuilder()
            ->andWhere('l.batch = :id')
            ->andWhere('l.type IN (:types) OR l.topic IN (:topics)')
            ->setParameter('id', $id)
            ->setParameter('types', [Log::TYPE_TEMPERATURE]) // Log::TYPE_TEMPERATURE
            ->setParameter('topics', ['phase.start']) // Log::TOPIC_PUMP_SET_STATE
//            ->setMaxResults(1000)
;

        return $qb->getQuery()->getResult();
    }
}
