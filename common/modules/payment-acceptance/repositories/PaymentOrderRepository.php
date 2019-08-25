<?php
/**
 * Файл класса PaymentOrderRepository
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\repositories;

use chulakov\components\repositories\Repository;
use common\modules\paymentacceptance\models\scopes\PaymentOrderQuery;
use common\modules\paymentacceptance\models\PaymentOrder;

class PaymentOrderRepository extends Repository
{
    /**
     * Модель поиска
     *
     * @return PaymentOrderQuery
     */
    public function query()
    {
        return PaymentOrder::find();
    }
}
