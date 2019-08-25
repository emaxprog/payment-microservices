<?php

namespace common\components\payment\services;

use chulakov\components\exceptions\NotFoundModelException;
use common\components\payment\models\repositories\TeamRepository;
use common\components\payment\models\repositories\UserRepository;

/**
 * Сервис получения данных по участникам команды
 *
 * @package common\components\payment\services
 */
class TeamService
{
    /**
     * @var TeamRepository
     */
    protected $repository;

    /**
     * Конструктор сервиса
     *
     * @param TeamRepository $repository
     */
    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получить команду
     *
     * @param $id
     * @return mixed
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function get($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Получить команды
     *
     * @return mixed
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function getTeams()
    {
        return $this->repository->getTeams();
    }

    /**
     * Получить идентификаторы участников команды по идентификатору команды
     *
     * @param $id
     * @return mixed
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function getTeamMembersIds($id)
    {
        return $this->repository->getTeamMembersIds($id);
    }

    /**
     * Получить идентификаторы участников команды по слагу команды
     *
     * @param $slug
     * @return mixed
     * @throws \chulakov\components\exceptions\NotFoundModelException
     */
    public function getTeamMembersIdsBySlug($slug)
    {
        $teams = $this->getTeams();
        if (!empty($teams)) {
            foreach ($teams as $team) {
                if ($slug == strtolower($team['name'])) {
                    return $this->getTeamMembersIds($team['id']);
                }
            }
            throw new NotFoundModelException('Команды "' . $slug . '" не существует!');
        }
        throw new NotFoundModelException('Команд не существует!');
    }

    /**
     * Получить участников команды по идентификатору команды§
     *
     * @param $id
     * @param bool $all
     * @return array
     * @throws \chulakov\components\exceptions\NotFoundModelException
     * @throws \yii\base\InvalidConfigException
     */
    public function getTeamMembers($id, $all = true)
    {
        $userService = new UserService(new UserRepository());
        $teamMembersIds = $this->getTeamMembersIds($id);
        $users = $all ? $userService->getUsersAll() : $userService->getUsers();
        $members = [];
        foreach ($users as $user) {
            if (in_array($user['id'], $teamMembersIds) && !$user['is_archived']) {
                $members[$user['id']] = $user;
            }
        }
        return $members;
    }
}
