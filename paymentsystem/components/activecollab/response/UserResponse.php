<?php
/**
 * Файл класса UserRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\response;

use common\components\activecollab\entities\User;

class UserResponse extends ResponseInterface
{
    /**
     * Преобразование данных
     *
     * @return User
     */
    public function decode()
    {
        return new User($this->data);
    }
}