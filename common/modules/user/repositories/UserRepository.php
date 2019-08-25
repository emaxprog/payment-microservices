<?php
/**
 * Файл класса UserRepository
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\repositories;

use Yii;
use chulakov\components\exceptions\NotFoundModelException;
use chulakov\components\repositories\Repository;
use common\modules\user\models\scopes\UserQuery;
use common\modules\user\models\User;

class UserRepository extends Repository
{
    /**
     * Модель поиска
     *
     * @return UserQuery
     */
    public function query()
    {
        return User::find();
    }

    /**
     * Поиск пользователя по логину
     *
     * @param string $username
     * @return User
     * @throws NotFoundModelException
     */
    public function findByUsername($username)
    {
        if ($model = $this->query()->byUsername($username)->one()) {
            return $model;
        }
        throw new NotFoundModelException(
            Yii::t('ch/user', 'User with username "{username}" not found.', [
                'username' => $username,
            ])
        );
    }

    /**
     * Поиск пользователя по email адресу
     *
     * @param string $email
     * @return User
     * @throws NotFoundModelException
     */
    public function findByEmail($email)
    {
        if ($model = $this->query()->byEmail($email)->one()) {
            return $model;
        }
        throw new NotFoundModelException(
            Yii::t('ch/user', 'User with email "{email}" not found.', [
                'email' => $email,
            ])
        );
    }

    /**
     * Поиск пользователя по токену запроса
     *
     * @param string $type
     * @param string $token
     * @return User
     * @throws NotFoundModelException
     */
    public function findByToken($type, $token)
    {
        if ($model = $this->query()->byRequestToken($type, $token)->one()) {
            return $model;
        }
        throw new NotFoundModelException(
            Yii::t('ch/user', 'User with request token "{token}" not found.', [
                'token' => $token,
            ])
        );
    }
}
