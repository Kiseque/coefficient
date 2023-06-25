<?php

namespace App\Entity;

use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'coefficients')]
class CoefficientsEntity
{
    #[Id]
    #[Column(name: 'id', type: Types::INTEGER)]
    #[GeneratedValue]
    private int $id;

    #[ManyToOne(targetEntity: EmployeeEntity::class, fetch: 'EAGER')]
    #[JoinColumn(name: 'employee_id', referencedColumnName: 'id')]
    private EmployeeEntity $employeeId;

    #[ManyToOne(targetEntity: WorkMonthEntity::class, fetch: 'EAGER')]
    #[JoinColumn(name: 'month_id', referencedColumnName: 'id')]
    private WorkMonthEntity $monthId;

    #[Column(name: 'coefficient', type: Types::FLOAT)]
    private float $coefficient;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return EmployeeEntity
     */
    public function getEmployeeId(): EmployeeEntity
    {
        return $this->employeeId;
    }

    /**
     * @param EmployeeEntity $employeeId
     */
    public function setEmployeeId(EmployeeEntity $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    /**
     * @return WorkMonthEntity
     */
    public function getMonthId(): WorkMonthEntity
    {
        return $this->monthId;
    }

    /**
     * @param WorkMonthEntity $monthId
     */
    public function setMonthId(WorkMonthEntity $monthId): void
    {
        $this->monthId = $monthId;
    }

    /**
     * @return float
     */
    public function getCoefficient(): float
    {
        return $this->coefficient;
    }

    /**
     * @param float $coefficient
     */
    public function setCoefficient(float $coefficient): void
    {
        $this->coefficient = $coefficient;
    }



}