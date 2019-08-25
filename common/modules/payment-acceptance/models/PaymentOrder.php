<?php
/**
 * Файл модели PaymentOrder
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use chulakov\components\models\ActiveRecord;
use common\modules\paymentacceptance\models\scopes\PaymentOrderQuery;
use common\modules\paymentacceptance\models\mappers\PaymentOrderMapper;

/**
 * Класс модели для работы с данными таблицы "payment_order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sum
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class PaymentOrder extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment_order}}';
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return PaymentOrderQuery
     */
    public static function find()
    {
        return new PaymentOrderQuery(get_called_class());
    }

    /**
     * @return PaymentOrderMapper
     */
    public static function mapper()
    {
        return PaymentOrderMapper::instance();
    }
}
