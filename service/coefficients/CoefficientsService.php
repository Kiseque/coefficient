<?php

namespace App\service\coefficients;

use App\Entity\CoefficientsEntity;
use App\Entity\EmployeeEntity;
use App\Entity\WorkMonthEntity;

require_once 'bootstrap.php';
class CoefficientsService
{
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = getEntityManager();
    }

    public function insertOrUpdateRowCoefficients(?int $id, int $employeeId, int $monthId)
    {
        if ($id != null) {
            $coeff = $this->entityManager->getRepository(CoefficientsEntity::class)->find($id);
        } else {
            $coeff = new CoefficientsEntity();
        }
        $emp = $this->entityManager->getRepository(EmployeeEntity::class)->find($employeeId);
        $mont = $this->entityManager->getRepository(WorkMonthEntity::class)->find($monthId);
        $coeff->setEmployeeId($emp);
        $coeff->setMonthId($mont);
        $this->entityManager->persist($coeff);
        $this->entityManager->flush();
    }

    public function deleteRowCoefficients(int $id)
    {
        $emp = $this->entityManager->getRepository(CoefficientsEntity::class)->find($id);
        $this->entityManager->remove($emp);
        $this->entityManager->flush();
    }

}