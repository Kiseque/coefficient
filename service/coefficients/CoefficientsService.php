<?php

namespace App\service\coefficients;

use App\Entity\CoefficientsEntity;
use App\Entity\EmployeeEntity;
use App\Entity\WorkMonthEntity;
use App\service\Constants;
use Error;
use Exception;

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
        try {
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
        } catch (Exception $e) {
            outputJson(false, $e->getMessage(), $e->getCode());
        } catch (Error $e) {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }

    public function deleteRowCoefficients(int $id)
    {
        try {
            $emp = $this->entityManager->getRepository(CoefficientsEntity::class)->find($id);
            $this->entityManager->remove($emp);
            $this->entityManager->flush();
        } catch (Exception $e) {
            outputJson(false, $e->getMessage(), $e->getCode());
        } catch (Error $e) {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }

}