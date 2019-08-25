<?php
/**
 * Файл класса ReportInterface
 *
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\reports;

use common\components\activecollab\models\repositories\TeamRepository;
use common\components\activecollab\models\repositories\UserRepository;
use common\components\activecollab\services\TeamService;
use common\components\activecollab\services\UserService;
use common\components\activecollab\services\UserTimeRecordsService;
use common\components\activecollab\models\repositories\UserTimeRecordsRepository;


/**
 * Интерфейс генерации отчетов по задачам
 *
 * @package common\components\activecollab\reports
 */
abstract class ReportInterface
{
    /**
     * @var UserTimeRecordsService
     */
    protected $service;
    /**
     * @var TeamService
     */
    protected $teamService;
    /**
     * @var TeamService
     */
    protected $userService;

    /**
     * ReportInterface constructor.
     */
    public function __construct()
    {
        $this->service = new UserTimeRecordsService(new UserTimeRecordsRepository());
        $this->teamService = new TeamService(new TeamRepository());
        $this->userService = new UserService(new UserRepository());
    }

    /**
     * Генерация отчета
     *
     * @param $userId
     * @param $from
     * @param $to
     * @return mixed
     */
    abstract public function render($userId, $from, $to);

    /**
     * Генерация отчета по идентификаторам пользователей
     *
     * @param array $ids
     * @param $from
     * @param $to
     * @return mixed
     */
    abstract public function renderByUsers(array $ids, $from, $to);

    /**
     * Генерация отчета по команде
     *
     * @param $id
     * @param $from
     * @param $to
     * @return mixed
     */
    abstract public function renderByTeam($id, $from, $to);
}