<?php

namespace App\Controller;

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
        if (isset($_GET)) {
            $this->employeesService->deleteEmployees($_GET['id']);
        } else {

        }
    }
}