<?php
/**
 * Файл класса TaskTimeRecordsRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\ResponseInterface;
use common\components\activecollab\response\UserTimeRecordsResponse;

/**
 * Класс для работы с временными записями работы над проектом
 *
 * @package common\components\activecollab\request
 */
class UserTimeRecordsRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = 'users/{user_id}/time-records';
    /**
     * @var int|null Номер страницы
     */
    protected $pageNumber;

    /**
     * Конструктор класса для работы с временными записями работы произведенной над проектом
     *
     * @param $userId
     * @param null $pageNumber
     */
    public function __construct($userId, $pageNumber = null)
    {
        $this->pageNumber = $pageNumber;
        $this->addTemplateParam('{user_id}', $userId);
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
        return new UserTimeRecordsResponse($status, $data);
    }
}