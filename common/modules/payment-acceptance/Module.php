<?php
/**
 * Файл модуля Module
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\payment-acceptance;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
            // 'default' => 'common\modules\payment-acceptance\controllers\DefaultController',
        ];
    }
}
