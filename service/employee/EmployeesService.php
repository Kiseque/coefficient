<?php

namespace App\service\employee;
use App\Entity\CoefficientsEntity;
use App\Entity\EmployeeEntity;
use App\service\Constants;
use Error;
use Exception;

require_once 'bootstrap.php';
class EmployeesService
{
    private $entityManager;
    public function __construct()
    {
        $this->entityManager = getEntityManager();
    }

    public function deleteEmployee($id)
    {
        try {
            $employee = $this->entityManager->getRepository(EmployeeEntity::class)->find($id);
            $this->entityManager->remove($employee);
            $coefficient = $this->entityManager->getRepository(CoefficientsEntity::class)->findBy(['employeeId' => $id]);
            foreach ($coefficient as $item) {
                $this->entityManager->remove($item);
            }
            $this->entityManager->flush();
        } catch (Exception $e) {
            outputJson(false, $e->getMessage(), $e->getCode());
        } catch (Error $e) {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }

}