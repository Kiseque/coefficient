<?php

namespace App\Controller;

use App\service\coefficients\CoefficientsService;
use App\service\Constants;

require_once "bootstrap.php";

class CoefficientsController
{
    private CoefficientsService $coefficientService;

    public function __construct()
    {
        $this->coefficientService = new CoefficientsService();
    }

    public function insertOrUpdateRowCoefficients()
    {
        if (isset($_GET['employeeId']) && isset($_GET['monthId'])) {
            $this->coefficientService->insertOrUpdateRowCoefficients($_GET['id'], $_GET['employeeId'], $_GET['monthId']);
        } else {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }

    public function deleteRowCoefficients()
    {
        if (isset($_GET['id'])) {
            $this->coefficientService->deleteRowCoefficients($_GET['id']);
        } else {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }

}