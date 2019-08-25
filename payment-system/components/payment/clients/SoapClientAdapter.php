<?php
/**
 * Файл класса SoapClientAdapter
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\clients;

use common\components\payment\requests\RequestInterface;
use Exception;
use SoapClient;
use yii\base\InvalidConfigException;

/**
 * Класс для работы с запросами
 *
 * @package common\components\payment
 */
class SoapClientAdapter implements ClientAdapterInterface
{
    /**
     * @var string
     */
    protected $baseUrl;
    /**
     * @var SoapClient
     */
    protected $client;
    /**
     * @var string|null
     */
    protected $authToken;
    /**
     * @var string|null
     */
    protected $authType;

    /**
     * Констурктор запросов
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->baseUrl = trim($url, '/');
    }

    /**
     * Запрос на сервер
     *
     * @param RequestInterface $method Вызываемый метод сервера
     * @throws Exception
     */
    public function send(RequestInterface $method)
    {
        throw new InvalidConfigException('Soap Client не реализован.');
    }
}