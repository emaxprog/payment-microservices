<?php
/**
 * Файл класса PaymentService
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\services;

use chulakov\components\exceptions\FormException;
use common\components\payment\PaymentSystem;
use common\components\payment\requests\RequestFactory;
use common\helpers\Random;
use common\modules\paymentsystem\jobs\PaymentOrderJob;
use common\modules\paymentsystem\models\forms\PaymentForm;
use common\modules\paymentsystem\models\Payment;
use common\modules\user\models\User;
use common\modules\user\services\AuthService;
use Exception;
use yii\queue\Queue;

class PaymentManagerService
{
    /**
     * @var PaymentService
     */
    protected $service;
    /**
     * @var AuthService;
     */
    protected $authService;
    /**
     * @var PaymentSystem
     */
    protected $paymentSystem;
    /**
     * @var Queue
     */
    protected $queue;

    /**
     * Конструктор сервиса
     *
     * @param PaymentService $service
     * @param PaymentSystem $paymentSystem
     * @param AuthService $authService
     * @param Queue $queue
     */
    public function __construct(
        PaymentService $service,
        PaymentSystem $paymentSystem,
        AuthService $authService,
        Queue $queue
    )
    {
        $this->service = $service;
        $this->paymentSystem = $paymentSystem;
        $this->authService = $authService;
        $this->queue = $queue;

    }

    /**
     * @throws FormException
     * @throws Exception
     */
    public function emulatePayment()
    {
        $models = [];
        for ($i = 0; $i < random_int(1, 10); $i++) {
            $user = User::findIdentity($i + 1);
            $this->authService->login($user);

            /**@var PaymentForm $form */
            $form = $this->service->form();
            $form->sum = random_int(10, 500);
            $form->commission = Random::floatRand(0, 2, 2);
            $form->order_number = $user->id;
            $models[] = $this->service->create($form);

            $this->queue->delay(20)->push(new PaymentOrderJob($this));
        }

        return $models;
    }

    /**
     * Оплата
     *
     * @param $id
     * @throws Exception
     */
    public function payment($id)
    {
        $payment = Payment::findOne(['id' => $id]);
        $user = User::findIdentity($payment->order_number);
        $authToken = $this->authService->login($user);
//        Yii::$app->get('paymentSystem');
        $this->paymentSystem->setAuthToken($authToken)->send(RequestFactory::makePaymentRequest($payment));
    }

}
