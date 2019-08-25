<?php
/**
 * Файл класса PaymentOrderFactory
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\models\factories;

use chulakov\components\exceptions\FormException;
use chulakov\components\models\factories\FactoryInterface;
use common\modules\paymentacceptance\models\mappers\PaymentOrderMapper;
use common\modules\paymentacceptance\models\search\PaymentOrderSearch;
use common\modules\paymentacceptance\models\forms\PaymentOrderForm;
use common\modules\paymentacceptance\models\PaymentOrder;

class PaymentOrderFactory implements FactoryInterface
{
    /**
     * Создать модель
     *
     * @param array $config
     * @return PaymentOrder
     */
    public function makeModel($config = [])
    {
        return new PaymentOrder($config);
    }

    /**
     * Создать поисковую модель
     *
     * @param array $config
     * @return PaymentOrderSearch
     */
    public function makeSearch($config = [])
    {
        return new PaymentOrderSearch($config);
    }

    /**
     * Создать форму
     *
     * @param PaymentOrderMapper $mapper
     * @param PaymentOrder $model
     * @param array $config
     * @return PaymentOrderForm
     * @throws FormException
     */
    public function makeForm($mapper, $model = null, $config = [])
    {
        return new PaymentOrderForm($mapper, $model, $config);
    }
}
