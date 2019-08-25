<?php
/**
 * Файл класса AuthenticateRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\requests;

use common\components\payment\responses\PaymentResponse;
use common\components\payment\responses\ResponseInterface;

/**
 * Класс для отправки запроса на совершение платежа
 *
 * @package common\components\payment\requests
 */
class PaymentRequest extends TypedRequestInterface
{
    /**
     * @var string
     */
    protected $method = 'payment';
    /**
     * Идентификатор транзакции
     *
     * @var string
     */
    protected $transactionId;
    /**
     * Сумма
     *
     * @var int
     */
    protected $sum;
    /**
     * Комиссия
     *
     * @var float
     */
    protected $commission;
    /**
     * Идентификатор клиента
     *
     * @var string
     */
    protected $orderNumber;

    /**
     * PaymentRequest constructor.
     *
     * @param string $transactionId
     * @param int $sum
     * @param float $commission
     * @param int $orderNumber
     */
    public function __construct($transactionId, $sum, $commission, $orderNumber)
    {
        $this->transactionId = $transactionId;
        $this->sum = $sum;
        $this->commission = $commission;
        $this->orderNumber = $orderNumber;
    }

    /**
     * Подготовка массива запроса
     *
     * @return array
     */
    public function getParams()
    {
        $request = [
            'id' => $this->transactionId,
            'sum' => $this->sum,
            'commission' => $this->commission,
            'order_number' => $this->orderNumber,
        ];
        return $request;
    }

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    public function buildResponse($status, $data)
    {
        return new PaymentResponse($status, $data);
    }

    /**
     * Тип запроса
     *
     * @return string
     */
    public function getRequestType()
    {
        return self::REQUEST_POST;
    }
}