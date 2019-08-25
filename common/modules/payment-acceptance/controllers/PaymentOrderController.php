<?php
/**
 * Файл контроллера MediaController
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\media\controllers;

use chulakov\components\rest\Controller;
use common\modules\paymentacceptance\bootstrap\PaymentOrderApiBootstrap;
use Yii;
use yii\base\Module;

class PaymentOrderController extends Controller
{
    /**
     * Конструктор контроллера
     *
     * @param string $id
     * @param Module $module
     * @param PaymentOrderApiBootstrap $bootstrap
     * @param array $config
     */
    public function __construct($id, Module $module, PaymentOrderApiBootstrap $bootstrap, array $config = [])
    {
        $bootstrap->bootstrap(Yii::$app);
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function accessRules()
    {
        return [
            'create' => $this->createAccess('get, post', true, '@'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'create' => 'common\modules\paymentacceptance\controllers\api\CreateAction',
        ];
    }
}
