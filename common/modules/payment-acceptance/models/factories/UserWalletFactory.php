<?php
/**
 * Файл класса UserWalletFactory
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\models\factories;

use chulakov\components\exceptions\FormException;
use chulakov\components\models\factories\FactoryInterface;
use common\modules\paymentacceptance\models\mappers\UserWalletMapper;
use common\modules\paymentacceptance\models\search\UserWalletSearch;
use common\modules\paymentacceptance\models\forms\UserWalletForm;
use common\modules\paymentacceptance\models\UserWallet;

class UserWalletFactory implements FactoryInterface
{
    /**
     * Создать модель
     *
     * @param array $config
     * @return UserWallet
     */
    public function makeModel($config = [])
    {
        return new UserWallet($config);
    }

    /**
     * Создать поисковую модель
     *
     * @param array $config
     * @return UserWalletSearch
     */
    public function makeSearch($config = [])
    {
        return new UserWalletSearch($config);
    }

    /**
     * Создать форму
     *
     * @param UserWalletMapper $mapper
     * @param UserWallet $model
     * @param array $config
     * @return UserWalletForm
     * @throws FormException
     */
    public function makeForm($mapper, $model = null, $config = [])
    {
        return new UserWalletForm($mapper, $model, $config);
    }
}
