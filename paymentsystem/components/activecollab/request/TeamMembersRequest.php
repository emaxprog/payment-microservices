<?php
/**
 * Файл класса UserRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\TeamMembersResponse;
use common\components\activecollab\response\ResponseInterface;

class TeamMembersRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = '/teams/{team_id}/members';

    /**
     * Конструктор класса для работы с пользователем команды
     *
     * @param integer $teamId
     */
    public function __construct($teamId)
    {
        $this->addTemplateParam('{team_id}', $teamId);
    }

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    public function buildResponse($status, $data)
    {
        return new TeamMembersResponse($status, $data);
    }
}