<?php
/**
 * Файл класса ExcelReport
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\reports;

use Yii;
use PHPExcel;
use PHPExcel_Worksheet;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Alignment;
use yii\helpers\ArrayHelper;

class ExcelReport extends ReportInterface
{
    /**
     * Генерация отчета по идентификаторам пользователей
     *
     * @param array $ids
     * @param $from
     * @param $to
     * @return string
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \chulakov\components\exceptions\NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function renderByUsers(array $ids, $from, $to)
    {
        $notEstimateTask = [];
        $users = $this->userService->getUsersByIds($ids);
        $xls = new PHPExcel();
        $sheet = $this->configureExcel($xls, 0, 'Эффективность специалистов');
        $this->writeMainPage($sheet, $users, $from, $to);
        $i = 1;
        foreach ($users as $user) {
            $userTimeRecordsFilteredByDate = $this->service->getUserTimeRecordsStat($user['id'], $from, $to);
            $notEstimateTask = ArrayHelper::merge($notEstimateTask, $userTimeRecordsFilteredByDate);
            $sheet = $this->configureExcel($xls, $i++, $user['display_name']);
            $this->writePage($sheet, $userTimeRecordsFilteredByDate);
        }
        $sheet = $this->configureExcel($xls, $i, 'Неоцениваемые задачи');
        ArrayHelper::multisort($notEstimateTask, 'is_completed', SORT_DESC);
        $this->writeNotEstimateTasks($sheet, $notEstimateTask, ArrayHelper::map($this->userService->getUsersAll(true), 'id', 'display_name'));
        return $this->saveExcel($xls, $from, $to);
    }

    /**
     * Генерация отчета по идентификатору команды
     *
     * @param $id
     * @param $from
     * @param $to
     * @return string
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \chulakov\components\exceptions\NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function renderByTeam($id, $from, $to)
    {
        $membersIds = $this->teamService->getTeamMembersIds($id);
        return $this->renderByUsers($membersIds, $from, $to);
    }

    /**
     * Генерация отчета по слагу команды
     *
     * @param $slug
     * @param $from
     * @param $to
     * @return string
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \chulakov\components\exceptions\NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function renderByTeamSlug($slug, $from, $to)
    {
        $membersIds = $this->teamService->getTeamMembersIdsBySlug($slug);
        return $this->renderByUsers($membersIds, $from, $to);
    }

    /**
     * Генерация отчета
     *
     * @param $userId
     * @param $from
     * @param $to
     * @param string $sheetTitle
     * @param int $sheetIndex
     * @return mixed|void
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \chulakov\components\exceptions\NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function render($userId, $from, $to, $sheetTitle = 'Отчет по эффективности', $sheetIndex = 0)
    {
        $userTimeRecordsFilteredByDate = $this->service->getUserTimeRecordsStat($userId, $from, $to);
        $xls = new PHPExcel();
        $sheet = $this->configureExcel($xls, $sheetIndex, $sheetTitle);
        $this->writePage($sheet, $userTimeRecordsFilteredByDate);
        $this->saveExcel($xls, $from, $to);
    }

    /**
     * Конфигурировать Excel файл
     *
     * @param PHPExcel $xls
     * @param $sheetIndex
     * @param $sheetTitle
     * @return PHPExcel_Worksheet
     * @throws \PHPExcel_Exception
     */
    public function configureExcel(PHPExcel $xls, $sheetIndex, $sheetTitle)
    {
        if ($sheetIndex) {
            $sheet = $xls->createSheet($sheetIndex);
        } else {
            $sheet = $xls->getActiveSheet();
        }
        $sheet->setTitle($sheetTitle);
        return $sheet;
    }

    /**
     * Сохранение Excel файла
     *
     * @param $xls
     * @param $from
     * @param $to
     * @throws \PHPExcel_Writer_Exception
     */
    public function saveExcel($xls, $from, $to)
    {
        $objWriter = new PHPExcel_Writer_Excel2007($xls);
        $reportName = 'task-report_' . $from . '_' . $to;
        $fileName = $reportName . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $objWriter->save('php://output');
    }

    /**
     * Заполнить сводную таблицу данными
     *
     * @param PHPExcel_Worksheet $sheet
     * @param array $data
     * @param $user
     * @param $rowNumber
     * @return mixed
     * @throws \PHPExcel_Exception
     * @throws \chulakov\components\exceptions\NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function writeMainData(PHPExcel_Worksheet $sheet, array $data, $user, $rowNumber)
    {
        if (empty($stat = $this->service->getUserStat($data, $user))) {
            return $rowNumber;
        }
        $sheet->setCellValueByColumnAndRow(0, $rowNumber, $user['display_name']);
        $sheet->setCellValueByColumnAndRow(1, $rowNumber, $stat['user_time_record']);
        $sheet->setCellValueByColumnAndRow(2, $rowNumber, $stat['estimate']);
        $sheet->setCellValueByColumnAndRow(3, $rowNumber, $stat['performance']);

        if ($stat['performance'] >= 100) {
            $this->stylizeMainPageRow($sheet, $rowNumber, 10, '7cff90');
        } else {
            if (is_numeric($stat['performance'])) {
                $this->stylizeMainPageRow($sheet, $rowNumber, 10, 'ff4444');
            } else {
                $this->stylizeMainPageRow($sheet, $rowNumber, 10);
            }
        }
        return ++$rowNumber;
    }

    /**
     * Заполнить сводную таблицу данными
     *
     * @param PHPExcel_Worksheet $sheet
     * @param $users
     * @param $from
     * @param $to
     * @throws \PHPExcel_Exception
     * @throws \chulakov\components\exceptions\NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function writeMainPage(PHPExcel_Worksheet $sheet, $users, $from, $to)
    {
        $sheet->setCellValueByColumnAndRow(0, 1, 'Исполнитель');
        $sheet->setCellValueByColumnAndRow(1, 1, 'Потрачено за период, ч');
        $sheet->setCellValueByColumnAndRow(2, 1, 'Продуктивность (Отгружено), ч');
        $sheet->setCellValueByColumnAndRow(3, 1, 'Эффективность, %');
        $this->stylizeMainPageHeader($sheet, 12, 'e2e2e2');
        $i = 2;
        foreach ($users as $user) {
            $userTimeRecordsFilteredByDate = $this->service->getUserTimeRecordsStat($user['id'], $from, $to);
            $i = $this->writeMainData($sheet, $userTimeRecordsFilteredByDate, $user, $i);
        }
    }


    /**
     * Заполнить таблицу данными
     *
     * @param PHPExcel_Worksheet $sheet
     * @param array $data
     * @throws \PHPExcel_Exception
     */
    public function writePage(PHPExcel_Worksheet $sheet, array $data)
    {
        $sheet->setCellValueByColumnAndRow(0, 1, 'Проект');
        $sheet->setCellValueByColumnAndRow(1, 1, 'Задача');
        $sheet->setCellValueByColumnAndRow(2, 1, 'Потрачено за период, ч');
        $sheet->setCellValueByColumnAndRow(3, 1, 'Потрачено всего, ч');
        $sheet->setCellValueByColumnAndRow(4, 1, 'Оценка, ч');
        $sheet->setCellValueByColumnAndRow(5, 1, 'Эффективность, %');
        $sheet->setCellValueByColumnAndRow(6, 1, 'Статус');
        $this->stylizeHeader($sheet, 12, 'e2e2e2');
        $i = 2;
        foreach ($data as $task) {
            $sheet->setCellValueByColumnAndRow(0, $i, $task['user_time_record']['type'] == 'Task' ? $task['project']['name'] : $task['name']);
            $sheet->setCellValueByColumnAndRow(1, $i, $task['user_time_record']['type'] == 'Task' ? $task['name'] : '-');
            if ($task['user_time_record']['type'] == 'Task') {
                $sheet->getCellByColumnAndRow(1, $i)->getHyperlink()->setUrl('http://ac.chulakov.ru' . $task['url_path']);
                $sheet->getCellByColumnAndRow(0, $i)->getHyperlink()->setUrl('http://ac.chulakov.ru' . $task['project']['url_path']);
            } else {
                $sheet->getCellByColumnAndRow(0, $i)->getHyperlink()->setUrl('http://ac.chulakov.ru' . $task['url_path']);
            }
            $sheet->setCellValueByColumnAndRow(2, $i, $task['user_time_record']['value']);
            $sheet->setCellValueByColumnAndRow(3, $i, $task['time_record']);
            $sheet->setCellValueByColumnAndRow(4, $i, $task['user_time_record']['type'] == 'Task' ? $task['estimate'] : '-');
            $sheet->setCellValueByColumnAndRow(5, $i, $task['user_time_record']['type'] == 'Task' ? $task['performance'] : '-');
            $sheet->setCellValueByColumnAndRow(6, $i, $task['is_completed'] ? 'Завершена' : 'Активная');
            if ($task['user_time_record']['type'] == 'Task') {
                if ($task['performance'] >= 100) {
                    $this->stylizePerformanceRow($sheet, $task, $i++, 10, '7cff90');
                } else {
                    if (is_numeric($task['performance'])) {
                        $this->stylizePerformanceRow($sheet, $task, $i++, 10, 'ff4444');
                    } else {
                        $this->stylizePerformanceRow($sheet, $task, $i++, 10);
                    }
                }
            } else {
                $this->stylizeTaskRow($sheet, $task, $i++, 10, '4934d8');
            }
        }
    }

    /**
     *
     *
     * @param PHPExcel_Worksheet $sheet
     * @param array $data
     * @param $users
     * @throws \PHPExcel_Exception
     */
    public function writeNotEstimateTasks(PHPExcel_Worksheet $sheet, array $data, $users)
    {
        $sheet->setCellValueByColumnAndRow(0, 1, 'Создатель');
        $sheet->setCellValueByColumnAndRow(1, 1, 'Проект');
        $sheet->setCellValueByColumnAndRow(2, 1, 'Задача');
        $sheet->setCellValueByColumnAndRow(3, 1, 'Статус');
        $this->stylizeNotTaskEstimateHeader($sheet, 12, 'e2e2e2');
        $i = 2;
        foreach ($data as $task) {
            if ($task['user_time_record']['type'] == 'Task') {
                $sheet->setCellValueByColumnAndRow(0, $i, $users[$task['created_by_id']]);
                $sheet->setCellValueByColumnAndRow(1, $i, $task['user_time_record']['type'] == 'Task' ? $task['project']['name'] : $task['name']);
                $sheet->setCellValueByColumnAndRow(2, $i, $task['user_time_record']['type'] == 'Task' ? $task['name'] : '-');
                $sheet->getCellByColumnAndRow(2, $i)->getHyperlink()->setUrl('http://ac.chulakov.ru' . $task['url_path']);
                $sheet->getCellByColumnAndRow(1, $i)->getHyperlink()->setUrl('http://ac.chulakov.ru' . $task['project']['url_path']);
                $sheet->setCellValueByColumnAndRow(3, $i, $task['is_completed'] ? 'Завершена' : 'Активная');
                $this->stylizeNotEstimateTaskRow($sheet, $task, $i++, 10);
            }
        }
    }

    /**
     * Стилизовать ячейки задачи
     *
     * @param PHPExcel_Worksheet $sheet
     * @param $rowNum
     * @param $task
     * @param int $fontSize
     * @throws \PHPExcel_Exception
     */
    public function stylizeNotEstimateTaskRow(PHPExcel_Worksheet $sheet, $task, $rowNum, $fontSize = 12)
    {
        if ($task['is_completed']) {
            $this->stylizeNotEstimateRow($sheet, $rowNum, $fontSize, 'ba59aa');
        } else {
            $this->stylizeNotEstimateRow($sheet, $rowNum, $fontSize, '00d8ff');
        }

    }

    /**
     * Стилизовать строку не оценочных задач
     *
     * @param PHPExcel_Worksheet $sheet
     * @param $rowNum
     * @param int $fontSize
     * @param string $styleColorStatus
     * @throws \PHPExcel_Exception
     */
    public function stylizeNotEstimateRow(PHPExcel_Worksheet $sheet, $rowNum, $fontSize = 12, $styleColorStatus = 'fffffff')
    {
        $rowCoordinates = 'A' . $rowNum . ':D' . $rowNum;
        $sheet->getStyle('A' . $rowNum . ':C' . $rowNum)
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D' . $rowNum)
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D' . $rowNum)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($styleColorStatus);
        $sheetRowStyle = $sheet->getStyle($rowCoordinates);
        $sheetRowStyle
            ->getFont()
            ->setSize($fontSize);
        $styleArray = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ]
        ];
        $sheetRowStyle->applyFromArray($styleArray);
    }

    /**
     * Стилизовать ячейки задачи
     *
     * @param PHPExcel_Worksheet $sheet
     * @param $rowNum
     * @param $task
     * @param int $fontSize
     * @param string $styleColorTask
     * @throws \PHPExcel_Exception
     */
    public function stylizeTaskRow(PHPExcel_Worksheet $sheet, $task, $rowNum, $fontSize = 12, $styleColorTask = 'ffffff')
    {
        if ($task['is_completed']) {
            $this->stylizeRow($sheet, $rowNum, $fontSize, 'ffffff', 'ba59aa', $styleColorTask);
        } else {
            $this->stylizeRow($sheet, $rowNum, $fontSize, 'ffffff', '00d8ff', $styleColorTask);
        }

    }

    /**
     * Стилизовать ячейки эффективности
     *
     * @param PHPExcel_Worksheet $sheet
     * @param $task
     * @param $rowNum
     * @param int $fontSize
     * @param string $styleColorPerformance
     * @throws \PHPExcel_Exception
     */
    public function stylizePerformanceRow(PHPExcel_Worksheet $sheet, $task, $rowNum, $fontSize = 12, $styleColorPerformance = 'ffffff')
    {
        if ($task['is_completed']) {
            $this->stylizeRow($sheet, $rowNum, $fontSize, $styleColorPerformance, 'ba59aa');
        } else {
            $this->stylizeRow($sheet, $rowNum, $fontSize, $styleColorPerformance, '00d8ff');
        }
    }

    /**
     * Добавление стилей для сводной таблицы
     *
     * @param PHPExcel_Worksheet $sheet
     * @param $rowNum
     * @param int $fontSize
     * @param string $styleColor
     * @throws \PHPExcel_Exception
     */
    public function stylizeMainPageRow(PHPExcel_Worksheet $sheet, $rowNum, $fontSize = 12, $styleColor = 'ffffff')
    {
        $rowCoordinates = 'A' . $rowNum . ':D' . $rowNum;
        $sheet->getStyle('A' . $rowNum)
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B' . $rowNum . ':D' . $rowNum)
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D' . $rowNum)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($styleColor);
        $sheetRowStyle = $sheet->getStyle($rowCoordinates);
        $sheetRowStyle
            ->getFont()
            ->setSize($fontSize);
        $styleArray = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ]
        ];
        $sheetRowStyle->applyFromArray($styleArray);
    }

    /**
     * Добавление стилей
     *
     * @param PHPExcel_Worksheet $sheet
     * @param $rowNum
     * @param int $fontSize
     * @param string $styleColorPerformance
     * @param string $styleColorStatus
     * @param string $styleColorTask
     * @throws \PHPExcel_Exception
     */
    public function stylizeRow(PHPExcel_Worksheet $sheet, $rowNum, $fontSize = 12, $styleColorPerformance = 'ffffff', $styleColorStatus = 'fffffff', $styleColorTask = 'ffffff')
    {
        $rowCoordinates = 'A' . $rowNum . ':G' . $rowNum;
        $sheet->getStyle('A' . $rowNum . ':B' . $rowNum)
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C' . $rowNum . ':G' . $rowNum)
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . $rowNum)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($styleColorTask);
        $sheet->getStyle('F' . $rowNum)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($styleColorPerformance);
        $sheet->getStyle('G' . $rowNum)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($styleColorStatus);
        $sheetRowStyle = $sheet->getStyle($rowCoordinates);
        $sheetRowStyle
            ->getFont()
            ->setSize($fontSize);
        $styleArray = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ]
        ];
        $sheetRowStyle->applyFromArray($styleArray);
    }

    /**
     * Стилизовать хедер
     *
     * @param PHPExcel_Worksheet $sheet
     * @param int $fontSize
     * @param string $styleColor
     * @throws \PHPExcel_Exception
     */
    public function stylizeMainPageHeader(PHPExcel_Worksheet $sheet, $fontSize = 12, $styleColor = 'ffffff')
    {
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheetRowStyle = $sheet->getStyle('A1:D1');
        $sheetRowStyle
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetRowStyle
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($styleColor);
        $sheetRowStyle
            ->getFont()
            ->setSize($fontSize)
            ->setBold(true);
        $styleArray = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ]
        ];
        $sheetRowStyle->applyFromArray($styleArray);
    }

    /**
     * Стилизовать хедер страницы неоцениваемых задач
     *
     * @param PHPExcel_Worksheet $sheet
     * @param int $fontSize
     * @param string $styleColor
     * @throws \PHPExcel_Exception
     */
    public function stylizeNotTaskEstimateHeader(PHPExcel_Worksheet $sheet, $fontSize = 12, $styleColor = 'ffffff')
    {
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheetRowStyle = $sheet->getStyle('A1:D1');
        $sheetRowStyle
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetRowStyle
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($styleColor);
        $sheetRowStyle
            ->getFont()
            ->setSize($fontSize)
            ->setBold(true);
        $styleArray = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ]
        ];
        $sheetRowStyle->applyFromArray($styleArray);
    }

    /**
     * Стилизовать хедер
     *
     * @param PHPExcel_Worksheet $sheet
     * @param int $fontSize
     * @param string $styleColor
     * @throws \PHPExcel_Exception
     */
    public function stylizeHeader(PHPExcel_Worksheet $sheet, $fontSize = 12, $styleColor = 'ffffff')
    {
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheetRowStyle = $sheet->getStyle('A1:G1');
        $sheetRowStyle
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetRowStyle
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB($styleColor);
        $sheetRowStyle
            ->getFont()
            ->setSize($fontSize)
            ->setBold(true);
        $styleArray = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ]
        ];
        $sheetRowStyle->applyFromArray($styleArray);
    }
}