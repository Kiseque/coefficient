<?php

namespace App\service\workmonth;
use App\Entity\CoefficientsEntity;
use App\Entity\WorkMonthEntity;
use App\service\Constants;
use Error;
use Exception;

require_once 'bootstrap.php';
class WorkMonthService
{
    private $entityManager;
    public function __construct()
    {
        $this->entityManager = getEntityManager();
    }

    public function deleteWorkMonth($id)
    {
        try {
            $workMonth = $this->entityManager->getRepository(WorkMonthEntity::class)->find($id);
            $this->entityManager->remove($workMonth);
            $coefficient = $this->entityManager->getRepository(CoefficientsEntity::class)->findBy(['monthId' => $id]);
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