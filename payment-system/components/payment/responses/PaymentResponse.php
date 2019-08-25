<?php
/**
 * Файл класса PaymentResponse
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\responses;

use common\components\payment\entities\UserWallet;

/**
 * Класс для приема ответа авторизации
 *
 * @package common\components\payment\response
 */
class PaymentResponse extends ResponseInterface
{
    /**
     * Преобразование содержимого
     *
     * @return UserWallet
     */
    public function decode()
    {
        return new UserWallet($this->data);
    }
}