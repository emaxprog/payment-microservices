<?php
/**
 * Файл класса RequestInterface
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\requests;

use common\components\payment\responses\ResponseInterface;

/**
 * Базовый интерфейс запросов
 *
 * @package common\components\payment\requests
 */
abstract class RequestInterface
{
    /**
     * @var string
     */
    protected $method;

    /**
     * Формирование URL адреса запроса
     *
     * @return string
     */
    public function getUrlPath()
    {
        return $this->method;
    }

    /**
     * Подготовка массива запроса
     *
     * @return array
     */
    public function getParams()
    {
        return [];
    }

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    abstract public function buildResponse($status, $data);
}
