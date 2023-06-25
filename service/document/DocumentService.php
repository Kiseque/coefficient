<?php

namespace App\service\document;

use App\Entity\CoefficientsEntity;
use App\Entity\EmployeeEntity;
use App\Entity\WorkMonthEntity;
use App\service\Constants;
use DateTime;
use Error;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DocumentService
{
    private $entityManager;
    public function __construct()
    {
        $this->entityManager = getEntityManager();
    }
    public function xlsxGet()
    {
        try {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . Constants::XLSX_FILE_NAME . date('_d.m.Y_H:i:s') . '.xlsx' . '"');
            header('Cache-Control: max-age=0');
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getColumnDimension('A')->setWidth(30);
            $sheet->setCellValue('A1', 'ФИО');
            $columnCounter = 'B';
            $sheet->getColumnDimension('B')->setWidth(30);
            $employees = $this->entityManager->getRepository(EmployeeEntity::class)->findBy([], ['surname' => 'ASC']);
            $months = $this->entityManager->getRepository(WorkMonthEntity::class)->findBy([], ['date' => 'DESC'], 6);
            foreach ($months as $month) {
                $sheet->setCellValue($columnCounter . '1', $month->getName() . ' ' . $month->getDate()->format('Y-m-d h:i:s'));
                $columnCounter++;
            }
            $row = 2;
            foreach ($employees as $employee) {
                $sheet->setCellValue('A' . $row, $employee->getSurname() . ' ' . $employee->getFirstName() . ' ' . $employee->getPatronymic());
                $columnCounter = 'B';
                foreach ($months as $month) {
                    $coefficient = $this->entityManager->getRepository(CoefficientsEntity::class)->findOneBy([
                        'employeeId' => $employee,
                        'monthId' => $month
                    ]);
                    if ($coefficient) {
                        $sheet->setCellValue($columnCounter . $row, $coefficient->getCoefficient());
                    } else {
                        $sheet->setCellValue($columnCounter . $row, '-');
                    }
                    $columnCounter++;
                    $sheet->getColumnDimension($columnCounter)->setWidth(30);
                }
                $row++;
            }
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        } catch (Exception $e) {
            outputJson(false, $e->getMessage(), $e->getCode());
        } catch (Error $e) {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }

    }

    function importColumnDataToDatabase()
    {
        try {
            $spreadsheet = IOFactory::load('C:\\Users\\User\\Downloads\\Coefficients_24.06.2023_00_02_50.xlsx');
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
            $entityManager = getEntityManager();
            $highestColumnIndex = $sheet->getHighestColumn();
            $monthAndDate = $sheet->getCellByColumnAndRow($highestColumnIndex, 1)->getValue();
            $monthAndDateParts = explode(' ', $monthAndDate);
            $monthName = $monthAndDateParts[0];
            $dateString = implode(' ', array_slice($monthAndDateParts, 1));
            $date = new DateTime($dateString);

            $workMonth = new WorkMonthEntity();
            $workMonth->setName($monthName);
            $workMonth->setDate($date);
            $entityManager->persist($workMonth);
            $entityManager->flush();

            $workMonthId = $entityManager->getRepository(WorkMonthEntity::class)->findOneBy(['id' => 'desc'], 1);

            for ($row = 2; $row <= $highestRow; $row++) {
                $cellValue = $sheet->getCellByColumnAndRow($highestColumnIndex, $row)->getValue();
                $empValue = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                $empParts = explode(' ', $empValue);
                $employeeSurname = $empParts[0];
                $employee = $entityManager->getRepository(EmployeeEntity::class)->findOneBy(['surname' => $employeeSurname]);

                $coefficient = new CoefficientsEntity();
                $coefficient->setEmployeeId($employee);
                $coefficient->setMonthId($workMonthId);
                $coefficient->setCoefficient($cellValue);

                $entityManager->persist($coefficient);
            }
            $entityManager->flush();
        } catch (Exception $e) {
            outputJson(false, $e->getMessage(), $e->getCode());
        } catch (Error $e) {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }

    }
}