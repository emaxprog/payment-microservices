<?php
/**
 * Файл модели UserWallet
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
use common\modules\paymentacceptance\models\scopes\UserWalletQuery;
use common\modules\paymentacceptance\models\mappers\UserWalletMapper;

/**
 * Класс модели для работы с данными таблицы "user_wallet".
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
class UserWallet extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_wallet}}';
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
     * @return UserWalletQuery
     */
    public static function find()
    {
        return new UserWalletQuery(get_called_class());
    }

    /**
     * @return UserWalletMapper
     */
    public static function mapper()
    {
        return UserWalletMapper::instance();
    }
}
