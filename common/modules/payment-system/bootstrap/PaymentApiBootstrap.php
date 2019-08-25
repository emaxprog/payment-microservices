<?php
/**
 * Файл класса PaymentApiBootstrap
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\bootstrap;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;

class PaymentApiBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function bootstrap($app)
    {
        Yii::$container->setDefinitions([
            'chulakov\components\models\mappers\Mapper' => 'common\modules\paymentsystem\models\mappers\PaymentMapper',
            'chulakov\components\models\factories\FactoryInterface' => 'common\modules\paymentsystem\models\factories\PaymentFactory',
            'chulakov\components\repositories\Repository' => 'common\modules\paymentsystem\repositories\PaymentRepository',
            'chulakov\components\services\Service' => 'common\modules\paymentsystem\services\PaymentService',
            'common\components\payment\PaymentSystem' => Yii::$app->get('paymentSystem'),
        ]);
    }
}
