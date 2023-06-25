<?php

namespace App\Controller;

use App\service\Constants;
use App\service\workmonth\WorkMonthService;

class WorkMonthController
{
    private WorkMonthService $workMonthService;
    public function __construct()
    {
        $this->workMonthService = new WorkMonthService();
    }

    public function deleteWorkMonth()
    {
        if (isset($_GET['id'])) {
            $this->workMonthService->deleteWorkMonth($_GET['id']);
        } else {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }


}