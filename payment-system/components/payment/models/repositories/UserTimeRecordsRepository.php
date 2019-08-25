<?php
/**
 * Файл класса UserTimeRecordsRepository
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\models\repositories;

use Yii;
use yii\di\Instance;
use common\components\payment\PaymentSystem;
use chulakov\components\exceptions\NotFoundModelException;

class UserTimeRecordsRepository
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
     * Поиск временных записей пользователя в заданном промежутке времени
     *
     * @param $id
     * @param $from
     * @param $to
     * @return mixed
     * @throws NotFoundModelException
     */
    public function getUserTimeRecordsFilteredByDate($id, $from, $to)
    {
        $userTimeRecordsFilteredByDate = $this->ac->getUserTimeRecordsFilteredByDate($id, $from, $to);
        if (!empty($userTimeRecordsFilteredByDate)) {
            return $userTimeRecordsFilteredByDate;
        }
        throw new NotFoundModelException("Не удалось найти зарегистрированное время пользователя \"{$id}\".");
    }
}
