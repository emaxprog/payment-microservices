<?php
/**
 * Файл класса AuthFactory
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\factories;

use common\modules\user\models\forms\LoginForm;
use common\modules\user\models\forms\ResetPasswordForm;
use common\modules\user\models\forms\ResetPasswordRequestForm;

class AuthFactory
{
    /**
     * Создание формы авторизации
     *
     * @param array $config
     * @return LoginForm
     */
    public function makeLogin($config = [])
    {
        return new LoginForm($config);
    }

    /**
     * Создание формы запроса токена для смены пароля
     *
     * @param array $config
     * @return ResetPasswordRequestForm
     */
    public function makePasswordRequest($config = [])
    {
        return new ResetPasswordRequestForm($config);
    }

    /**
     * Создание формы сброса пароля
     *
     * @param string $token
     * @param array $config
     * @return ResetPasswordForm
     */
    public function makePasswordReset($token, $config = [])
    {
        return new ResetPasswordForm($token, $config);
    }
}
