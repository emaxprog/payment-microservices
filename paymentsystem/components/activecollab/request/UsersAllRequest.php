<?php
/**
 * Файл класса UserRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\UsersAllResponse;
use common\components\activecollab\response\ResponseInterface;

class UsersAllRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = '/users/all';

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    public function buildResponse($status, $data)
    {
        return new UsersAllResponse($status, $data);
    }
}