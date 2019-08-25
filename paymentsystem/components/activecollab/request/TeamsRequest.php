<?php
/**
 * Файл класса TeamRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\ResponseInterface;
use common\components\activecollab\response\TeamsResponse;

class TeamsRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = '/teams';

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    public function buildResponse($status, $data)
    {
        return new TeamsResponse($status, $data);
    }
}