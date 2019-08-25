<?php
/**
 * Файл класса CreateAction
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\insight\controllers\actions;

use chulakov\components\response\HTTP;
use chulakov\components\rest\Controller;
use common\modules\paymentacceptance\models\PaymentOrder;
use common\modules\paymentacceptance\services\PaymentOrderService;
use common\modules\paymentsystem\models\forms\PaymentForm;
use Exception;
use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;

/**
 * Class CreateAction
 * @package common\modules\insight\controllers\actions
 */
class CreateAction extends Action
{
    /**
     * @var Controller
     */
    public $controller;

    /**
     * @var PaymentOrderService
     */
    protected $service;

    /**
     * Конструктор действия для добавления заявки
     *
     * @param $id
     * @param Controller $controller
     * @param PaymentOrderService $service
     * @param array $config
     */
    public function __construct($id, Controller $controller, PaymentOrderService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $controller, $config);
    }

    /**
     * Выполнение действия добавления инсайта
     *
     * @return array
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function run()
    {
        /**@var PaymentForm $form */
        $form = $this->service->form();

        if ($form->load(Yii::$app->request->post(), '') && $form->validate()) {
            /** @var PaymentOrder $model */
            if ($model = $this->service->create($form)) {
                return $this->controller->successResult(HTTP::SUCCESS_ACCEPTED, $model->toArray());
            }
        }

        return $this->controller->errorResult($form, 'Не валидные данные платежа.');
    }
}
