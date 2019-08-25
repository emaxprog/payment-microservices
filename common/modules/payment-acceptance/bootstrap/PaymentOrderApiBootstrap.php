<?php
/**
 * Файл класса PaymentOrderApiBootstrap
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\bootstrap;

use Yii;
use yii\base\BootstrapInterface;

class PaymentOrderApiBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::$container->setDefinitions([
            'chulakov\components\models\mappers\Mapper' => 'common\modules\paymentacceptance\models\mappers\PaymentOrderMapper',
            'chulakov\components\models\factories\FactoryInterface' => 'common\modules\paymentacceptance\models\factories\PaymentOrderFactory',
            'chulakov\components\repositories\Repository' => 'common\modules\paymentacceptance\repositories\PaymentOrderRepository',
            'chulakov\components\services\Service' => 'common\modules\paymentacceptance\services\PaymentOrderService',
            'common\modules\paymentacceptance\models\mappers\UserWalletMapper' => 'common\modules\paymentacceptance\models\mappers\UserWalletMapper',
            'common\modules\paymentacceptance\models\factories\UserWalletFactory' => 'common\modules\paymentacceptance\models\factories\UserWalletFactory',
            'common\modules\paymentacceptance\repositories\UserWalletRepository' => 'common\modules\paymentacceptance\repositories\UserWalletRepository',
            'common\modules\paymentacceptance\services\UserWalletService' => 'common\modules\paymentacceptance\services\UserWalletService',
        ]);
    }
}
