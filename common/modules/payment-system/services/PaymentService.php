<?php
/**
 * Файл класса PaymentService
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\services;

use chulakov\components\services\Service;
use common\modules\paymentsystem\repositories\PaymentRepository;
use common\modules\paymentsystem\models\factories\PaymentFactory;
use common\modules\paymentsystem\models\mappers\PaymentMapper;

class PaymentService extends Service
{
    /**
     * Конструктор сервиса
     *
     * @param PaymentRepository $repository
     * @param PaymentFactory $factory
     * @param PaymentMapper $mapper
     */
    public function __construct(
        PaymentRepository $repository,
        PaymentFactory $factory,
        PaymentMapper $mapper
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mapper = $mapper;
    }
}
