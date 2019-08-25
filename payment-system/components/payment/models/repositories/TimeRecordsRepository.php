<?php
/**
 * Файл класса TimeRecordsRepository
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\models\repositories;

use Yii;
use yii\di\Instance;
use common\components\payment\PaymentSystem;
use chulakov\components\exceptions\NotFoundModelException;

class TimeRecordsRepository
{
    /**
     * @var PaymentSystem|string
     */
    public $ac = 'activeCollab';

    /**
     * UserTimeRecordsRepository constructor.
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct()
    {
        $this->ac = Instance::ensure($this->ac);
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
        $timeRecords = $this->ac->getTaskTimeRecords($projectId, $taskId);
        if (!empty($timeRecords)) {
            return $timeRecords;
        }
        throw new NotFoundModelException("Не удалось найти зарегистрированное время по задаче \"{$taskId}\".");
    }
}
