<?php
/**
 * Файл класса PaymentSearch
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\models\search;

use Yii;
use yii\db\ActiveQuery;
use chulakov\components\models\search\SearchForm;
use common\modules\paymentsystem\models\Payment;

class PaymentSearch extends SearchForm
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
        return Payment::find();
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }
}
