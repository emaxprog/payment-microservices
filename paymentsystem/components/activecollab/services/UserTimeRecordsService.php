<?php

namespace common\components\activecollab\services;

use chulakov\components\exceptions\NotFoundModelException;
use common\components\activecollab\models\repositories\TimeRecordsRepository;
use common\components\activecollab\models\UserTimeRecords;
use common\components\activecollab\models\repositories\UserTimeRecordsRepository;
use yii\helpers\ArrayHelper;

/**
 * Сервис получения данных по затратам времени на задачи
 *
 * @package common\components\activecollab\services
 */
class UserTimeRecordsService
{
    /**
     * @var UserTimeRecordsRepository
     */
    protected $repository;

    /**
     * Конструктор сервиса
     *
     * @param UserTimeRecordsRepository $repository
     */
    public function __construct(UserTimeRecordsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Поиск временных записей пользователя
     *
     * @param $id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getUserTimeRecords($id)
    {
        $userTimeRecordPaginate = new UserTimeRecords($id);
        $times = [];
        while ($page = $userTimeRecordPaginate->nextPage()) {
            $resTimeRecords = $page->time_records;

            if (empty($resTimeRecords)) {
                break;
            }

            foreach ($resTimeRecords as $timeRecord) {
                if (isset($times[$timeRecord['parent_id']])) {
                    $times[$timeRecord['parent_id']]['value'] += $timeRecord['value'];
                } else {
                    $times[$timeRecord['parent_id']] = $timeRecord;
                }
            }
        }

        return $times;
    }

    /**
     * Поиск временных записей пользователя
     *
     * @param $id
     * @param $from
     * @param $to
     * @return mixed
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function getUserTimeRecordsFilteredByDate($id, $from, $to)
    {
        $times = [];
        $userTimeRecordsFilteredByDate = $this->repository->getUserTimeRecordsFilteredByDate($id, $from, $to);
        if (!$resTimeRecords = $userTimeRecordsFilteredByDate->time_records) {
            return $times;
        }
        $resProjects = isset($userTimeRecordsFilteredByDate->related['Project']) ? $userTimeRecordsFilteredByDate->related['Project'] : null;
        $resTasks = isset($userTimeRecordsFilteredByDate->related['Task']) ? $userTimeRecordsFilteredByDate->related['Task'] : null;

        if (!$resProjects && !$resTasks) {
            throw new NotFoundModelException('Не существует записей времени в проектах и задачах в выбранном промежутке времени!');
        }

        foreach ($resTimeRecords as $timeRecord) {
            if ($timeRecord['parent_type'] == 'Task') {
                if (isset($times[$timeRecord['parent_id']])) {
                    $times[$timeRecord['parent_id']]['value'] += $timeRecord['value'];
                    $times[$timeRecord['parent_id']]['type'] = 'Task';
                } else {
                    $times[$timeRecord['parent_id']]['value'] = $timeRecord['value'];
                    $times[$timeRecord['parent_id']]['type'] = 'Task';
                }
            }
            if ($timeRecord['parent_type'] == 'Project') {
                if (isset($times[$timeRecord['parent_id']])) {
                    $times[$timeRecord['parent_id']]['value'] += $timeRecord['value'];
                    $times[$timeRecord['parent_id']]['type'] = 'Project';
                } else {
                    $times[$timeRecord['parent_id']]['value'] = $timeRecord['value'];
                    $times[$timeRecord['parent_id']]['type'] = 'Project';
                }
            }
        }

        foreach ($times as $taskId => $time) {
            if ($time['type'] == 'Task') {
                $project = $resProjects[$resTasks[$taskId]['project_id']];
                $resTasks[$taskId]['project'] = $project;
            } else {
                $resTasks[$taskId] = $resProjects[$taskId];
            }
            $resTasks[$taskId]['user_time_record'] = $time;
        }

        return $resTasks;
    }

    /**
     * Получение статистики выполнения задач за промежуток времени
     *
     * @param $id
     * @param $from
     * @param $to
     * @return mixed
     * @throws \chulakov\components\exceptions\NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function getUserTimeRecordsStat($id, $from, $to)
    {
        $userTimeRecords = $this->getUserTimeRecords($id);
        $userTimeRecordsFilteredByDate = $this->getUserTimeRecordsFilteredByDate($id, $from, $to);
        foreach ($userTimeRecordsFilteredByDate as &$task) {
            $task['time_record'] = $userTimeRecords[$task['id']]['value'];
            if ($task['user_time_record']['type'] == 'Task') {
                $task['estimate'] = $this->getProportionalEstimateForUser($id, $task['project_id'], $task['id']);
                $task['performance'] = $task['estimate'] ? round(($task['estimate'] / $task['time_record']) * 100) : '-';
            }
        }
        ArrayHelper::multisort($userTimeRecordsFilteredByDate, ['is_completed', 'updated_on'], [SORT_DESC, SORT_DESC]);
        unset($task);
        return $userTimeRecordsFilteredByDate;
    }

    /**
     * Получить пропорциональную оценку
     *
     * @param $id
     * @param $projectId
     * @param $taskId
     * @return float
     * @throws NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function getProportionalEstimateForUser($id, $projectId, $taskId)
    {
        $timeRecordsRes = (new TimeRecordsService(new TimeRecordsRepository()))->getTimeRecordsByProjectAndTask($projectId, $taskId);
        $timeRecords = $timeRecordsRes->time_records;
        if (empty($timeRecords) || !isset($timeRecordsRes->related['Task'])) {
            return 0;
        }
        $task = $timeRecordsRes->related['Task'];
        $ratio = [];
        $commonTime = 0;
        foreach ($timeRecords as $time) {
            if (isset($ratio[$time['user_id']])) {
                $ratio[$time['user_id']] += $time['value'];
            } else {
                $ratio[$time['user_id']] = $time['value'];
            }
            $commonTime += $time['value'];
        }

        foreach ($ratio as $userId => $time) {
            $ratio[$userId] = $time / $commonTime;
        }

        return round($task[$taskId]['estimate'] * $ratio[$id]);
    }

    /**
     * Получение статистики эффективности сотрудника за промежуток времени
     *
     * @param $data
     * @param $user
     * @return array
     * @throws NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function getUserStat($data, $user)
    {
        $userTimeRecord = $estimate = 0;
        foreach ($data as $task) {
            $userTimeRecord += $task['user_time_record']['value'];
            if ($task['is_completed'] && isset($task['estimate']) && ($proportionalEstimate = $this->getProportionalEstimateForUser($user['id'], $task['project']['id'], $task['id']))) {
                $estimate += $proportionalEstimate;
            }
        }

        return [
            'user_time_record' => $userTimeRecord,
            'estimate' => $estimate,
            'performance' => $estimate && $userTimeRecord ? round(($estimate / $userTimeRecord) * 100) : '-'
        ];
    }
}
