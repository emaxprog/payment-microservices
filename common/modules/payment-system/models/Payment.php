<?php
/**
 * Файл модели Payment
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use chulakov\components\models\ActiveRecord;
use common\modules\paymentsystem\models\scopes\PaymentQuery;
use common\modules\paymentsystem\models\mappers\PaymentMapper;

/**
 * Класс модели для работы с данными таблицы "payment".
 *
 * @property integer $id
 * @property integer $sum
 * @property double $commission
 * @property integer $order_number
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $orderNumber
 */
class Payment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getOrderNumber()
    {
        return $this->hasOne(User::className(), ['id' => 'order_number']);
    }

    /**
     * @return PaymentQuery
     */
    public static function find()
    {
        return new PaymentQuery(get_called_class());
    }

    /**
     * @return PaymentMapper
     */
    public static function mapper()
    {
        return PaymentMapper::instance();
    }
}
