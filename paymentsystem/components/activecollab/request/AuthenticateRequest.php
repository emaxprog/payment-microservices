<?php
/**
 * Файл класса AuthenticateRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\ResponseInterface;
use common\components\activecollab\response\AuthenticateResponse;

/**
 * Класс для отправки запроса на авторизацию
 *
 * @package common\components\activecollab\request
 */
class AuthenticateRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = 'issue-token';
    /**
     * @var string
     */
    protected $user;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $applicationName;
    /**
     * @var string
     */
    protected $companyName;

    /**
     * Конструктор запроса
     *
     * @param string $user
     * @param string $password
     * @param string $appName
     * @param string $companyName
     */
    public function __construct($user, $password, $appName, $companyName)
    {
        $this->user = $user;
        $this->password = $password;
        $this->applicationName = $appName;
        $this->companyName = $companyName;
    }

    /**
     * Подготовка массива запроса
     *
     * @return array
     */
    public function getParams()
    {
        $request = [
            'username' => $this->user,
            'password' => $this->password,
            'client_name' => $this->applicationName,
            'client_vendor' => $this->companyName,
        ];
        return $request;
    }

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    public function buildResponse($status, $data)
    {
        return new AuthenticateResponse($status, $data);
    }
}