<?php
/**
 * Файл класса UserWalletService
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\services;

use chulakov\components\services\Service;
use common\modules\paymentacceptance\repositories\UserWalletRepository;
use common\modules\paymentacceptance\models\factories\UserWalletFactory;
use common\modules\paymentacceptance\models\mappers\UserWalletMapper;

class UserWalletService extends Service
{
    /**
     * Конструктор сервиса
     *
     * @param UserWalletRepository $repository
     * @param UserWalletFactory $factory
     * @param UserWalletMapper $mapper
     */
    public function __construct(
        UserWalletRepository $repository,
        UserWalletFactory $factory,
        UserWalletMapper $mapper
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mapper = $mapper;
    }
}
