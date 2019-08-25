<?php
/**
 * Файл класса Client
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab;

use yii\base\Component;
use common\components\activecollab\request\RequestInterface;
use common\components\activecollab\response\ResponseInterface;

/**
 * Класс для работы с клиентской частью
 *
 * @package common\components\activecollab
 */
class Client extends Component
{
    /**
     * @var string Базовый Url
     */
    protected $baseUrl;
    /**
     * @var integer Версия ActiveCollab API
     */
    protected $apiVersion;
    /**
     * @var Request
     */
    protected $request;

    /**
     * Конструктор клиента
     *
     * @param string $baseUrl
     * @param integer $apiVersion
     * @param array $config
     */
    public function __construct($baseUrl, $apiVersion, array $config = [])
    {
        $this->baseUrl = $baseUrl;
        $this->apiVersion = $apiVersion;

        parent::__construct($config);
    }

    /**
     * Добавление токена
     *
     * @param string $authToken
     */
    public function setAuthKey($authToken)
    {
        $this->getRequest()->setAuthKey($authToken);
    }

    /**
     * Отправка POST запроса
     *
     * @param RequestInterface $method
     * @return ResponseInterface
     * @throws \Exception
     */
    public function post(RequestInterface $method)
    {
        return $this->sendRequest($method, Request::REQUEST_POST);
    }

    /**
     * Отправка GET запроса
     *
     * @param RequestInterface $method
     * @return ResponseInterface
     * @throws \Exception
     */
    public function get(RequestInterface $method)
    {
        return $this->sendRequest($method, Request::REQUEST_GET);
    }

    /**
     * Отправка PUT запроса
     *
     * @param RequestInterface $method
     * @return ResponseInterface
     * @throws \Exception
     */
    public function put(RequestInterface $method)
    {
        return $this->sendRequest($method, Request::REQUEST_PUT);
    }

    /**
     * Отправка PATCH запроса
     *
     * @param RequestInterface $method
     * @return ResponseInterface
     * @throws \Exception
     */
    public function patch(RequestInterface $method)
    {
        return $this->sendRequest($method, Request::REQUEST_PATCH);
    }

    /**
     * Отправка DELETE запроса
     *
     * @param RequestInterface $method
     * @return ResponseInterface
     * @throws \Exception
     */
    public function delete(RequestInterface $method)
    {
        return $this->sendRequest($method, Request::REQUEST_DELETE);
    }

    /**
     * Отправка запроса
     *
     * @param RequestInterface $method
     * @param string $requestType
     * @return ResponseInterface
     * @throws \Exception
     */
    protected function sendRequest($method, $requestType)
    {
        return $this->getRequest()->send($method, $requestType);
    }

    /**
     * Компонент запросов к серверу
     *
     * @return Request
     */
    protected function getRequest()
    {
        if (is_null($this->request)) {
            $this->request = new Request(
                $this->buildUrl()
            );
        }
        return $this->request;
    }

    /**
     * Формирование url для работы с API
     *
     * @return string
     */
    protected function buildUrl()
    {
        return $this->baseUrl . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'v' . $this->apiVersion . DIRECTORY_SEPARATOR;
    }
}