<?php
/**
 * Файл класса UserWalletQuery
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\models\scopes;

use chulakov\components\models\scopes\ActiveQuery;
use chulakov\components\models\scopes\QueryIdTrait;

class UserWalletQuery extends ActiveQuery
{
    use QueryIdTrait;
}
