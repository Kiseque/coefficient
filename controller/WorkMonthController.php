<?php

namespace App\Controller;


use App\Entity\WorkMonthEntity;
use App\service\workmonth\WorkMonthService;


class WorkMonthController
{
    private WorkMonthService $workMonthService;
    public function __construct()
    {
        $this->workMonthService = new WorkMonthService();
    }

    function getLastSixMonth()
    {
        $this->workMonthService->getLastSixMonth();
    }


}