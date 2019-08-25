<?php
/**
 * Файл класса PaymentRepository
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\repositories;

use chulakov\components\repositories\Repository;
use common\modules\paymentsystem\models\scopes\PaymentQuery;
use common\modules\paymentsystem\models\Payment;

class PaymentRepository extends Repository
{
    /**
     * Модель поиска
     *
     * @return PaymentQuery
     */
    public function query()
    {
        return Payment::find();
    }
}
