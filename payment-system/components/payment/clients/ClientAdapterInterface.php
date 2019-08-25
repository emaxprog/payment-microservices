<?php
/**
 * Файл класса ClientAdapterInterface
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\clients;

use common\components\payment\requests\RequestInterface;
use common\components\payment\responses\ResponseInterface;

/**
 * Класс для работы с запросами
 *
 * @package common\components\payment
 */
interface ClientAdapterInterface
{
    /**
     * Запрос на сервер
     *
     * @param RequestInterface $method Вызываемый метод сервера
     * @return ResponseInterface
     * @throws \Exception
     */
    public function send(RequestInterface $method);
}