<?php
/**
 * Файл класса UserWalletRepository
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\repositories;

use chulakov\components\repositories\Repository;
use common\modules\paymentacceptance\models\scopes\UserWalletQuery;
use common\modules\paymentacceptance\models\UserWallet;

class UserWalletRepository extends Repository
{
    /**
     * Модель поиска
     *
     * @return UserWalletQuery
     */
    public function query()
    {
        return UserWallet::find();
    }
}
