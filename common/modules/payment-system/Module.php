<?php
/**
 * Файл модуля Module
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
             'payment' => 'common\modules\paymentsystem\controllers\PaymentController',
        ];
    }
}
