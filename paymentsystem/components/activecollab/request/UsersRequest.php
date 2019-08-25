<?php
/**
 * Файл класса UserRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\UsersResponse;
use common\components\activecollab\response\ResponseInterface;

class UsersRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = '/users';

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    public function buildResponse($status, $data)
    {
        return new UsersResponse($status, $data);
    }
}