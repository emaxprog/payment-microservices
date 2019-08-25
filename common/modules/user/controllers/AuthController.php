<?php
/**
 * Файл класса AuthController
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers;

use chulakov\components\base\AccessRule;
use chulakov\components\web\Controller;

class AuthController extends Controller
{
    /**
     * Список правил доступа к экшенам контроллера.
     *
     * @return AccessRule[]
     */
    public function accessRules()
    {
        return [
            'logout' => $this->createAccess('post', true, '@'),
            'login' => $this->createAccess('get, post', true, '?'),
            'recovery' => $this->createAccess('get, post', true, '?'),
            'reset' => $this->createAccess('get, post', true, '?'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'logout' => 'common\modules\user\controllers\auth\LogoutAction',
            'login' => 'common\modules\user\controllers\auth\LoginAction',
            'recovery' => 'common\modules\user\controllers\auth\ResetPasswordRequestAction',
            'reset' => 'common\modules\user\controllers\auth\ResetPasswordAction',
        ];
    }
}
