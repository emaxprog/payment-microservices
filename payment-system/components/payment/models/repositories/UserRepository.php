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

class UserRepository
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
     * Получить пользователя по идентификатору
     *
     * @param $id
     * @return array|\common\components\payment\request\UserRequest
     * @throws NotFoundModelException
     */
    public function get($id)
    {
        if ($user = $this->ac->getUser($id)) {
            return $user;
        }
        throw new NotFoundModelException("Не удалось найти пользователя с идентификатором \"{$id}\".");
    }

    /**
     * Поиск временных записей пользователя в заданном промежутке времени
     *
     * @return mixed
     * @throws NotFoundModelException
     */
    public function getUsers()
    {
        $users = $this->ac->getUsers();
        if (!empty($users)) {
            return $users;
        }
        throw new NotFoundModelException("Не удалось найти пользователей!");
    }

    /**
     * Поиск временных записей пользователя в заданном промежутке времени
     *
     * @return mixed
     * @throws NotFoundModelException
     */
    public function getUsersAll()
    {
        $users = $this->ac->getUsersAll();
        if (!empty($users)) {
            return $users;
        }
        throw new NotFoundModelException("Не удалось найти пользователей!");
    }
}
