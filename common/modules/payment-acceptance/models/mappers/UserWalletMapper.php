<?php
/**
 * Файл класса UserWalletMapper
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\models\mappers;

use Yii;
use chulakov\components\base\SingletonTrait;
use chulakov\components\models\mappers\Mapper;
use chulakov\components\models\mappers\types\NullType;
use chulakov\components\models\mappers\types\ModelType;
use common\modules\paymentacceptance\models\UserWallet;

class UserWalletMapper extends Mapper
{
    use SingletonTrait;

    /**
     * @inheritdoc
     */
    public function initFillAttributes()
    {
        return ['user_id', 'sum'];
    }

    /**
     * @inheritdoc
     */
    public function initAcceptedModelTypes()
    {
        return [
            new NullType(),
            new ModelType(UserWallet::class),
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelRules()
    {
        return [
            [['user_id', 'sum'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelLabels()
    {
        return [
            'id' => Yii::t('ch/paymentacceptance', 'ID'),
            'user_id' => Yii::t('ch/paymentacceptance', 'User ID'),
            'sum' => Yii::t('ch/paymentacceptance', 'Sum'),
            'created_by' => Yii::t('ch/paymentacceptance', 'Created By'),
            'updated_by' => Yii::t('ch/paymentacceptance', 'Updated By'),
            'created_at' => Yii::t('ch/paymentacceptance', 'Created At'),
            'updated_at' => Yii::t('ch/paymentacceptance', 'Updated At'),
        ];
    }
}
