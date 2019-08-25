<?php
/**
 * Файл класса Request
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab;

use GuzzleHttp\RequestOptions;
use common\components\activecollab\request\RequestInterface;
use common\components\activecollab\response\ResponseInterface;

/**
 * Класс для работы с запросами
 *
 * @package common\components\activecollab
 */
class Request
{
    const REQUEST_POST = 'post';
    const REQUEST_GET = 'get';
    const REQUEST_PUT = 'put';
    const REQUEST_PATCH = 'patch';
    const REQUEST_DELETE = 'delete';

    /**
     * @var string
     */
    protected $baseUrl;
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;
    /**
     * @var string|null
     */
    protected $authToken;

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
     * @throws \Exception
     */
    public function send(RequestInterface $method, $requestType = self::REQUEST_POST)
    {
        $response = $this->request(
            $requestType,
            $method->getUrlPath(),
            $method->getParams(),
            $method->getCurrentPage()
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
     * @param integer $pageNumber
     * @return \GuzzleHttp\Message\FutureResponse|\Psr\Http\Message\ResponseInterface
     */
    protected function request($type, $path, $params, $pageNumber)
    {
        return $this->getClient()->{$type}(
            $this->makeUrl($path, $pageNumber), $this->makeParams($params, $type)
        );
    }

    /**
     * Подготовка URL для запроса
     *
     * @param string $path
     * @param integer $pageNumber
     * @return string
     */
    protected function makeUrl($path, $pageNumber)
    {
        return !is_null($pageNumber)
            ? "{$this->baseUrl}/{$path}" . '?page=' . $pageNumber
            : "{$this->baseUrl}/{$path}";
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
                    'X-Angie-AuthApiToken' => $this->authToken
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
     * @throws \Exception
     */
    protected function parseResponse($stream)
    {
        return json_decode($stream, true);
    }

    /**
     * Получение HTTP клиента.
     * С предворительной инициализацией и дефолтной конфигурацией
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new \GuzzleHttp\Client([
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