<?php
/**
 * Файл класса UserWalletSearch
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\models\search;

use Yii;
use yii\db\ActiveQuery;
use chulakov\components\models\search\SearchForm;
use common\modules\paymentacceptance\models\UserWallet;

class UserWalletSearch extends SearchForm
{

    /**
     * @inheritdoc
     */
    protected function buildSort()
    {
        return [
           'defaultOrder' => [
               'id' => SORT_ASC,
           ],
           'attributes' => ['id'],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery()
    {
        return UserWallet::find();
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }
}
