<?php
/**
 * Файл класса UserRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\UserResponse;
use common\components\activecollab\response\ResponseInterface;

class UserRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = '/users/{user_id}';

    /**
     * Конструктор класса для работы с пользователем
     *
     * @param integer $userId
     */
    public function __construct($userId)
    {
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
        return new UserResponse($status, $data);
    }
}