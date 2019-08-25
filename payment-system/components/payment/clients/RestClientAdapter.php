<?php
/**
 * Файл класса RestClientAdapter
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\clients;

use common\components\payment\requests\RequestInterface;
use common\components\payment\requests\TypedRequestInterface;
use common\components\payment\responses\ResponseInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

/**
 * Класс для работы с запросами
 *
 * @package common\components\payment
 */
class RestClientAdapter implements ClientAdapterInterface
{
    /**
     * @var string
     */
    protected $baseUrl;
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var string|null
     */
    protected $authToken;
    /**
     * @var string|null
     */
    protected $authType = 'Bearer';

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
     * @param string $requestType
     * @return ResponseInterface
     * @throws Exception
     */
    public function send(RequestInterface $method, $requestType = TypedRequestInterface::REQUEST_POST)
    {
        $response = $this->request(
            $requestType,
            $method->getUrlPath(),
            $method->getParams()
        );
        $body = $this->parseResponse(
            $response->getBody()
        );
        return $method->buildResponse(
            $response->getStatusCode(), $body
        );
    }

    /**
     * Установка ключа авторизации
     *
     * @param string $token
     */
    public function setAuthKey($token)
    {
        $this->authToken = $token;
    }

    /**
     * Отправка запроса
     *
     * @param string $type
     * @param string $path
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function request($type, $path, $params)
    {
        return $this->getClient()->{$type}(
            "{$this->baseUrl}/{$path}", $this->makeParams($params, $type)
        );
    }

    /**
     * Создание и подписание запроса
     *
     * @param $params
     * @param $type
     * @return array
     */
    protected function makeParams($params, $type)
    {
        if (!empty($params)) {
            $params = $type == 'get' ? [
                RequestOptions::QUERY => $params
            ] : [
                RequestOptions::FORM_PARAMS => $params,
            ];
        }

        if (!empty($this->authToken)) {
            $params = array_merge($params, [
                RequestOptions::HEADERS => [
                    'Authorization' => $this->authType . ' ' . $this->authToken
                ]
            ]);
        }

        return $params;
    }

    /**
     * Разбор ответа
     *
     * @param string $stream
     * @return array
     * @throws Exception
     */
    protected function parseResponse($stream)
    {
        return json_decode($stream, true);
    }

    /**
     * Получение HTTP клиента.
     * С предворительной инициализацией и дефолтной конфигурацией
     *
     * @return Client
     */
    protected function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client([
                RequestOptions::ALLOW_REDIRECTS => [
                    'max' => 10,
                    'strict' => true,
                    'referer' => true,
                    'track_redirects' => true,
                ],
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        }
        return $this->client;
    }
}