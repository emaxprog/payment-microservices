<?php
/**
 * Файл класса PaymentFactory
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\models\factories;

use chulakov\components\exceptions\FormException;
use chulakov\components\models\factories\FactoryInterface;
use common\modules\paymentsystem\models\mappers\PaymentMapper;
use common\modules\paymentsystem\models\search\PaymentSearch;
use common\modules\paymentsystem\models\forms\PaymentForm;
use common\modules\paymentsystem\models\Payment;

class PaymentFactory implements FactoryInterface
{
    /**
     * Создать модель
     *
     * @param array $config
     * @return Payment
     */
    public function makeModel($config = [])
    {
        return new Payment($config);
    }

    /**
     * Создать поисковую модель
     *
     * @param array $config
     * @return PaymentSearch
     */
    public function makeSearch($config = [])
    {
        return new PaymentSearch($config);
    }

    /**
     * Создать форму
     *
     * @param PaymentMapper $mapper
     * @param Payment $model
     * @param array $config
     * @return PaymentForm
     * @throws FormException
     */
    public function makeForm($mapper, $model = null, $config = [])
    {
        return new PaymentForm($mapper, $model, $config);
    }
}
