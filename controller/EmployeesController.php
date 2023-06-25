<?php

namespace App\Controller;

use App\service\Constants;
use App\service\employee\EmployeesService;

class EmployeesController
{
    private EmployeesService $employeesService;

    public function __construct()
    {
        $this->employeesService = new EmployeesService();
    }

    public function deleteEmployee()
    {
        if (isset($_GET['id'])) {
            $this->employeesService->deleteEmployee($_GET['id']);
        } else {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }
}