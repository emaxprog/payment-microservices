<?php
/**
 * Файл модуля BackendModule
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user;

class BackendModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
            'default' => 'common\modules\user\controllers\DefaultController',
            'profile' => 'common\modules\user\controllers\ProfileController',
        ];
    }
}
