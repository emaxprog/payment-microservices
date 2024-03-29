<?php

namespace common\components\payment\services;

use chulakov\components\exceptions\NotFoundModelException;
use common\components\payment\models\repositories\TimeRecordsRepository;
use common\components\payment\models\UserTimeRecords;
use common\components\payment\models\repositories\UserTimeRecordsRepository;
use yii\helpers\ArrayHelper;

/**
 * Сервис получения данных по затратам времени на задачи
 *
 * @package common\components\payment\services
 */
class TimeRecordsService
{
    /**
     * @var TimeRecordsRepository
     */
    protected $repository;

    /**
     * Конструктор сервиса
     *
     * @param TimeRecordsRepository $repository
     */
    public function __construct(TimeRecordsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Поиск временных записей пользователя по задаче
     *
     * @param $projectId
     * @param $taskId
     * @return mixed
     * @throws NotFoundModelException
     */
    public function getTimeRecordsByProjectAndTask($projectId, $taskId)
    {
        return $this->repository->getTimeRecordsByProjectAndTask($projectId, $taskId);
    }
}
