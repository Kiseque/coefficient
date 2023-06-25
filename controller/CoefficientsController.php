<?php

namespace App\Controller;

use App\Entity\CoefficientsEntity;
use App\Entity\EmployeeEntity;
use App\Entity\WorkMonthEntity;
use App\service\coefficients\CoefficientsService;

require_once "bootstrap.php";

class CoefficientsController
{
    private CoefficientsService $coefficientService;

    public function __construct()
    {
        $this->coefficientService = new CoefficientsService();
    }

    public function x()
    {
        $entityManager = getEntityManager();
        $months = $entityManager->getRepository(WorkMonthEntity::class)->findAll();
        foreach ($months as $month) {
            var_dump($month->getDate()->format('d/m/Y')); die;
        }
    }

    public function insertOrUpdateRowCoefficients()
    {
        if (isset($_GET['employeeId']) && isset($_GET['monthId'])) {
            $this->coefficientService->insertOrUpdateRowCoefficients($_GET['id'], $_GET['employeeId'], $_GET['monthId']);
        } else {
            outputJson(false, 'Bad request', 400);
        }
    }

    public function deleteRowCoefficients()
    {
        if (isset($_GET['id'])) {
            $this->coefficientService->deleteRowCoefficients($_GET['id']);
        } else {
            outputJson(false, 'Bad request', 400);
        }
    }

}