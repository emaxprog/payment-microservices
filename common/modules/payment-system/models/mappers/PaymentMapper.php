<?php
/**
 * Файл класса PaymentMapper
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\models\mappers;

use Yii;
use chulakov\components\base\SingletonTrait;
use chulakov\components\models\mappers\Mapper;
use chulakov\components\models\mappers\types\NullType;
use chulakov\components\models\mappers\types\ModelType;
use common\modules\paymentsystem\models\Payment;

class PaymentMapper extends Mapper
{
    use SingletonTrait;

    /**
     * @inheritdoc
     */
    public function initFillAttributes()
    {
        return ['sum', 'commission', 'order_number'];
    }

    /**
     * @inheritdoc
     */
    public function initAcceptedModelTypes()
    {
        return [
            new NullType(),
            new ModelType(Payment::class),
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelRules()
    {
        return [
            [['sum', 'commission'], 'required'],
            [['sum', 'order_number'], 'integer'],
            [['commission'], 'number'],
            [['order_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['order_number' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelLabels()
    {
        return [
            'id' => Yii::t('ch/paymentsystem', 'ID'),
            'sum' => Yii::t('ch/paymentsystem', 'Sum'),
            'commission' => Yii::t('ch/paymentsystem', 'Commission'),
            'order_number' => Yii::t('ch/paymentsystem', 'Order Number'),
            'created_by' => Yii::t('ch/paymentsystem', 'Created By'),
            'updated_by' => Yii::t('ch/paymentsystem', 'Updated By'),
            'created_at' => Yii::t('ch/paymentsystem', 'Created At'),
            'updated_at' => Yii::t('ch/paymentsystem', 'Updated At'),
        ];
    }
}
