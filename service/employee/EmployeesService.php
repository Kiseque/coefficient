<?php

namespace App\service\employee;
use App\Entity\CoefficientsEntity;
use App\Entity\EmployeeEntity;

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
        $employee = $this->entityManager->getRepository(EmployeeEntity::class)->find($id);
        $this->entityManager->remove($employee);
        $coefficient = $this->entityManager->getRepository(CoefficientsEntity::class)->find($id);
        $this->entityManager->remove($coefficient);
        $this->entityManager->flush();
    }
}