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

class TeamRepository
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
     * Поиск команды
     *
     * @param $id
     * @return array|\common\components\payment\request\UserRequest
     * @throws NotFoundModelException
     */
    public function get($id)
    {
        $team = $this->ac->getTeam($id);
        if (!empty($team)) {
            return $team;
        }
        throw new NotFoundModelException("Не удалось найти команду с идентификатором \"{$id}\".");
    }

    /**
     * Поиск команд
     *
     * @return array|\common\components\payment\request\UserRequest
     * @throws NotFoundModelException
     */
    public function getTeams()
    {
        $teams = $this->ac->getTeams();
        if (!empty($teams)) {
            return $teams;
        }
        throw new NotFoundModelException("Не удалось найти команды.");
    }

    /**
     * Поиск временных записей пользователя в заданном промежутке времени
     *
     * @param $id
     * @return array|\common\components\payment\request\UserRequest
     * @throws NotFoundModelException
     */
    public function getTeamMembersIds($id)
    {
        $members = $this->ac->getTeamMembers($id);
        if (!empty($members)) {
            return $members;
        }
        throw new NotFoundModelException("Не удалось найти участников команды с идентификатором \"{$id}\".");
    }
}
