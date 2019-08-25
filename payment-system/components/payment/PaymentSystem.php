<?php
/**
 * Файл класса ActiveCollab
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment;


use common\components\payment\clients\Client;
use common\components\payment\requests\RequestInterface;
use Exception;
use yii\base\BaseObject;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Класс компонент для работы с Системой оплаты
 *
 * @package common\components\payment
 */
class PaymentSystem extends Component
{
    /**
     * @var string URL сервера обработки запросов
     */
    public $baseUrl;
    /**
     * @var integer Версия API
     */
    public $apiVersion;
    /**
     * @var string Токен авторизации
     */
    protected $authToken;
    /**
     * @var Client Клиент
     */
    protected $_client;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->baseUrl)) {
            throw new InvalidConfigException('Необходимо настроить URL сервера запросов.');
        }
    }

    /**
     * Отправка запроса и получение ответа на GET запрос
     *
     * @param RequestInterface $request
     * @return BaseObject|array
     * @throws Exception
     */
    public function send(RequestInterface $request)
    {
        return $this->getClient()->send($request)->decode();
    }

    /**
     * Получить клиент
     *
     * @return Client
     * @throws Exception
     */
    public function getClient()
    {
        if (is_null($this->_client)) {
            $this->_client = new Client(
                $this->baseUrl, $this->apiVersion
            );
            $this->_client->setAuthKey(
                $this->getAuthToken()
            );
        }
        return $this->_client;
    }

    /**
     * Получить токен авторизации
     *
     * @return string
     * @throws Exception
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * Установить токен авторизации
     *
     * @param string $token
     * @return PaymentSystem
     */
    public function setAuthToken($token)
    {
        $this->authToken = $token;
        return $this;
    }
}