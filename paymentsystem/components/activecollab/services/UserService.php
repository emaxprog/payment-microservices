<?php

namespace common\components\activecollab\services;

use common\components\activecollab\models\repositories\UserRepository;
use yii\helpers\ArrayHelper;

/**
 * Сервис получения данных пользователей
 *
 * @package common\components\activecollab\services
 */
class UserService
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * Конструктор сервиса
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получить пользователя по идентификатору
     *
     * @param $id
     * @return array|\common\components\activecollab\request\UserRequest
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function get($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Получить всех пользователей
     *
     * @return mixed
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function getUsers()
    {
        return $this->repository->getUsers();
    }

    /**
     * Получить всех пользователей
     *
     * @param bool $archived
     * @return array
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function getUsersAll($archived = false)
    {
        $result = [];
        $users = $this->repository->getUsersAll();
        if ($archived) {
            return $users;
        }
        foreach ($users as $user) {
            if (!$user['is_archived']) {
                $result[$user['id']] = $user;
            }
        }
        return $result;
    }

    /**
     * Получить пользователей по идентификаторам
     *
     * @param array $ids
     * @return array
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function getUsersByIds(array $ids)
    {
        $result = [];
        $users = $this->repository->getUsersAll();
        foreach ($users as $user) {
            if (in_array($user['id'], $ids) && !$user['is_archived']) {
                $result[$user['id']] = $user;
            }
        }
        ArrayHelper::multisort($result, 'display_name');
        return $result;
    }
}
