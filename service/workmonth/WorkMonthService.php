<?php

namespace App\service\workmonth;
use App\Entity\WorkMonthEntity;

require_once 'bootstrap.php';
class WorkMonthService
{
    public function getLastSixMonth()
    {
        $entityManager = getEntityManager();
        $month = $entityManager->getRepository(WorkMonthEntity::class);
        $query = $month->createQueryBuilder('work_month')
            ->orderBy('work_month.date', 'DESC')
            ->setMaxResults(6)
            ->getQuery();
        $sortedEntities = $query->getResult();
    }

}