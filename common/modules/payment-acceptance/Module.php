<?php
/**
 * Файл модуля Module
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->controllerMap = [
             'payment' => 'common\modules\paymentacceptance\controllers\PaymentController',
        ];
    }
}
