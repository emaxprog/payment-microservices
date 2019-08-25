<?php
/**
 * Файл класса RestRequestInterface
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\requests;

/**
 * Базовый интерфейс запросов
 *
 * @package common\components\payment\requests
 */
abstract class TypedRequestInterface extends RequestInterface
{
    const REQUEST_POST = 'post';
    const REQUEST_GET = 'get';
    const REQUEST_PUT = 'put';
    const REQUEST_PATCH = 'patch';
    const REQUEST_DELETE = 'delete';

    /**
     * Тип запроса
     *
     * @return string
     */
    abstract public function getRequestType();
}
