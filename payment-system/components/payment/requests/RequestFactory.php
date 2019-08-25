<?php
/**
 * Файл класса RestRequestInterface
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\requests;

use common\modules\paymentsystem\models\Payment;

/**
 * Базовый интерфейс запросов
 *
 * @package common\components\payment\requests
 */
abstract class RequestFactory
{
    /**
     * Тип запроса
     *
     * @param Payment $payment
     * @return RequestInterface|PaymentRequest
     */
    public static function makePaymentRequest(Payment $payment)
    {
        return new PaymentRequest($payment->id, $payment->sum, $payment->commission, $payment->order_number);
    }
}
