<?php
/**
 * Файл класса ActiveCollab
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab;

use common\components\activecollab\request\TaskTimeRecordsRequest;
use common\components\activecollab\request\TeamMembersRequest;
use common\components\activecollab\request\TeamRequest;
use common\components\activecollab\request\TeamsRequest;
use common\components\activecollab\request\UsersAllRequest;
use common\components\activecollab\request\UsersRequest;
use common\components\activecollab\request\UserTimeRecordsRequest;
use common\components\activecollab\request\UserTimeRecordsFilteredByDateRequest;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\components\activecollab\entities\Value;
use common\components\activecollab\entities\Project;
use common\components\activecollab\entities\TimeRecords;
use common\components\activecollab\entities\Authenticate;
use common\components\activecollab\entities\ProjectBudget;
use common\components\activecollab\request\UserRequest;
use common\components\activecollab\request\ProjectRequest;
use common\components\activecollab\request\RequestInterface;
use common\components\activecollab\request\TimeRecordsRequest;
use common\components\activecollab\request\AuthenticateRequest;
use common\components\activecollab\request\ProjectBudgetRequest;

/**
 * Класс компонент для работы с ActiveCollab
 *
 * @package common\components\activecollab
 */
class ActiveCollab extends Component
{
    /**
     * @var string Логин
     */
    public $user;
    /**
     * @var string Пароль
     */
    public $password;
    /**
     * @var string Имя приложения
     */
    public $applicationName;
    /**
     * @var string Название организации
     */
    public $companyName;
    /**
     * @var string URL сервера обработки запросов
     */
    public $baseUrl;
    /**
     * @var integer Версия ActiveCollab API
     */
    public $apiVersion = 5;
    /**
     * @var Client Клиент для работы с AC
     */
    protected $_client;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->user)) {
            throw new InvalidConfigException('Необходимо заполнить поле с логином.');
        }
        if (empty($this->password)) {
            throw new InvalidConfigException('Необходимо заполнить поле с паролем.');
        }
        if (empty($this->applicationName)) {
            throw new InvalidConfigException('Необходимо заполнить поле с названием приложения.');
        }
        if (empty($this->companyName)) {
            throw new InvalidConfigException('Необходимо заполнить поле с названием организации');
        }
        if (empty($this->baseUrl)) {
            throw new InvalidConfigException('Необходимо настроить URL сервера запросов.');
        }
    }

    /**
     * Получить пользователя по его идентификатору
     *
     * @param integer $userId
     * @return UserRequest|array
     * @throws \Exception
     */
    public function getUser($userId)
    {
        return $this->get(new UserRequest($userId));
    }

    /**
     * Получить пользователей
     *
     * @return UserRequest|array
     * @throws \Exception
     */
    public function getUsers()
    {
        return $this->get(new UsersRequest());
    }

    /**
     * Получить пользователей
     *
     * @return UsersAllRequest|array
     * @throws \Exception
     */
    public function getUsersAll()
    {
        return $this->get(new UsersAllRequest());
    }

    /**
     * Получить команду
     *
     * @param $id
     * @return array|Value
     * @throws \Exception
     */
    public function getTeam($id)
    {
        return $this->get(new TeamRequest($id));
    }

    /**
     * Получить команды
     *
     * @param $id
     * @return array|Value
     * @throws \Exception
     */
    public function getTeams()
    {
        return $this->get(new TeamsRequest());
    }

    /**
     * Получить участников команды по идентификатору команды
     *
     * @param $id
     * @return array|Value
     * @throws \Exception
     */
    public function getTeamMembers($id)
    {
        return $this->get(new TeamMembersRequest($id));
    }

    /**
     * Получить проект
     *
     * @param integer $projectId
     * @return Project|array
     * @throws \Exception
     */
    public function getProject($projectId)
    {
        return $this->get(new ProjectRequest($projectId));
    }

    /**
     * Получить бюджет проекта
     *
     * @param integer $projectId
     * @return ProjectBudget|array
     * @throws \Exception
     */
    public function getProjectBudget($projectId)
    {
        return $this->get(new ProjectBudgetRequest($projectId));
    }

    /**
     * Получить временные записи работы над проектом
     *
     * @param integer $projectId
     * @param integer $pageNumber
     * @return TimeRecords|array
     * @throws \Exception
     */
    public function getTimeRecords($projectId, $pageNumber = null)
    {
        return $this->get(new TimeRecordsRequest($projectId, $pageNumber));
    }

    /**
     * Получить временные записи работы над задачей
     *
     * @param integer $projectId
     * @param integer $taskId
     * @return TimeRecords|array
     * @throws \Exception
     */
    public function getTaskTimeRecords($projectId, $taskId)
    {
        return $this->get(new TaskTimeRecordsRequest($projectId, $taskId));
    }

    /**
     * Получить временные записи пользователя
     *
     * @param $userId
     * @param null $pageNumber
     * @return array|Value
     * @throws \Exception
     */
    public function getUserTimeRecords($userId, $pageNumber = null)
    {
        return $this->get(new UserTimeRecordsRequest($userId, $pageNumber));
    }

    /**
     * Получить временные записи отфильтрованные по диапазону
     *
     * @param $userId
     * @param $from
     * @param $to
     * @param null $pageNumber
     * @return array|Value
     * @throws \Exception
     */
    public function getUserTimeRecordsFilteredByDate($userId, $from, $to, $pageNumber = null)
    {
        return $this->get(new UserTimeRecordsFilteredByDateRequest($userId, $from, $to, $pageNumber));
    }

    /**
     * Отправка запроса и получение ответа на GET запрос
     *
     * @param RequestInterface $request
     * @return Value|array
     * @throws \Exception
     */
    public function get(RequestInterface $request)
    {
        return $this->getClient()->get(
            $request
        )->decode();
    }

    /**
     * Получить клиент
     *
     * @return Client
     * @throws \Exception
     */
    public function getClient()
    {
        if (is_null($this->_client)) {
            $this->_client = new Client(
                $this->baseUrl, $this->apiVersion
            );
            $this->_client->setAuthKey(
                $this->getToken()
            );
        }
        return $this->_client;
    }

    /**
     * Получить токен
     *
     * @return string
     * @throws \Exception
     */
    protected function getToken()
    {
        return \Yii::$app->cache->getOrSet('acAuthToken', function () {
            return $this->authenticate();
        });
    }

    /**
     * Авторизация в ActiveCollab
     *
     * @return string
     * @throws \Exception
     */
    protected function authenticate()
    {
        /** @var Authenticate $auth */
        $auth = $this->getClient()->post(new AuthenticateRequest(
            $this->user,
            $this->password,
            $this->applicationName,
            $this->companyName
        ))->decode();

        if (!$auth->is_ok) {
            throw new \Exception("Ошибка при получении токена.");
        }

        return $auth->token;
    }
}