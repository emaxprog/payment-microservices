<?php
/**
 * Файл класса UserModule
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user;

use yii\base\Module;

class UserModule extends Module
{
    public function init()
    {
        parent::init();
        $this->controllerMap = [
            'default' => $this->controllerNamespace . '\\DefaultController',
        ];
    }
}
