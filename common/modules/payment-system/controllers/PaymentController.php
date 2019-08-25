<?php
/**
 * Файл контроллера PaymentController
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\controllers;

use chulakov\components\rest\Controller;
use common\modules\media\bootstrap\MediaApiBootstrap;
use common\modules\paymentsystem\bootstrap\PaymentApiBootstrap;
use Yii;
use yii\base\Module;

class PaymentController extends Controller
{
    /**
     * @var array Массив действий, исключенных из проверки авторизации
     */
    public $authenticatorExcept = ['index'];

    /**
     * Конструктор контроллера
     *
     * @param string $id
     * @param Module $module
     * @param PaymentApiBootstrap $bootstrap
     * @param array $config
     */
    public function __construct($id, Module $module, PaymentApiBootstrap $bootstrap, array $config = [])
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
            'index' => $this->createAccess('get', true),
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => 'common\modules\paymentsystem\controllers\api\IndexAction',
        ];
    }
}
