<?php
/**
 * Файл класса PaymentQuery
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\models\scopes;

use chulakov\components\models\scopes\ActiveQuery;
use chulakov\components\models\scopes\QueryIdTrait;

class PaymentQuery extends ActiveQuery
{
    use QueryIdTrait;
}
