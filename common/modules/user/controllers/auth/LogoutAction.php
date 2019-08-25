<?php
/**
 * Файл класса LogoutAction
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers\auth;

use Yii;
use yii\base\Action;
use yii\web\Response;

/**
 * Действие выхода из системы
 */
class LogoutAction extends Action
{
    /**
     * Выполнение действия
     *
     * @return Response
     */
    public function run()
    {
        Yii::$app->user->logout();
        return $this->controller->goHome();
    }
}
