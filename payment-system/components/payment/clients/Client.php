<?php
/**
 * Файл класса Client
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\clients;

use common\components\payment\requests\RequestInterface;
use common\components\payment\requests\TypedRequestInterface;
use common\components\payment\responses\ResponseInterface;
use Exception;
use yii\base\Component;

/**
 * Класс для работы с клиентской частью
 *
 * @package common\components\payment
 */
class Client extends Component
{
    /**
     * @var string Базовый Url
     */
    protected $baseUrl;
    /**
     * @var integer Версия API
     */
    protected $apiVersion;
    /**
     * @var ClientAdapterInterface
     */
    protected $clientAdapter;

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
        $this->getClientAdapter()->setAuthKey($authToken);
    }

    /**
     * Отправка запроса
     *
     * @param RequestInterface $method
     * @return ResponseInterface
     * @throws Exception
     */
    public function send($method)
    {
        $clientAdapter = $this->getClientAdapter();

        if ($method instanceof TypedRequestInterface) {
            /**@var TypedRequestInterface $method */
            return $clientAdapter->send($method, $method->getRequestType());
        }

        return $clientAdapter->send($method);
    }

    /**
     * Компонент запросов к серверу
     *
     * @return ClientAdapterInterface|RestClientAdapter|SoapClientAdapter
     */
    protected function getClientAdapter()
    {
        if (is_null($this->clientAdapter)) {
            $this->clientAdapter = new ClientAdapter(
                $this->buildUrl()
            );
        }
        return $this->clientAdapter;
    }

    /**
     * Формирование url для работы с API
     *
     * @return string
     */
    protected function buildUrl()
    {
        if ($this->apiVersion) {
            return $this->baseUrl . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'v' . $this->apiVersion;
        }

        return $this->baseUrl;
    }
}