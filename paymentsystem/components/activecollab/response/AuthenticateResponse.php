<?php
/**
 * Файл класса AuthenticateRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\response;

use common\components\activecollab\entities\Authenticate;

/**
 * Класс для приема ответа авторизации
 *
 * @package common\components\activecollab\response
 */
class AuthenticateResponse extends ResponseInterface
{
    /**
     * Преобразование содержимого
     *
     * @return Authenticate
     */
    public function decode()
    {
        return new Authenticate($this->data);
    }
}