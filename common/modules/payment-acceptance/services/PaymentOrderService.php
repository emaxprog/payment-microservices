<?php
/**
 * Файл класса PaymentOrderService
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\services;

use chulakov\components\exceptions\SaveModelException;
use chulakov\components\services\Service;
use common\modules\paymentacceptance\models\factories\PaymentOrderFactory;
use common\modules\paymentacceptance\models\mappers\PaymentOrderMapper;
use common\modules\paymentacceptance\repositories\PaymentOrderRepository;
use yii\base\Model;
use yii\db\ActiveRecord;

class PaymentOrderService extends Service
{
    /**
     * @var UserWalletService
     */
    protected $userWalletService;

    /**
     * Конструктор сервиса
     *
     * @param PaymentOrderRepository $repository
     * @param PaymentOrderFactory $factory
     * @param PaymentOrderMapper $mapper
     * @param UserWalletService $userWalletService
     */
    public function __construct(
        PaymentOrderRepository $repository,
        PaymentOrderFactory $factory,
        PaymentOrderMapper $mapper,
        UserWalletService $userWalletService
    )
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mapper = $mapper;
        $this->userWalletService = $userWalletService;
    }

    /**
     * Обновление информации в объекте
     *
     * @param ActiveRecord $model
     * @param Model $form
     * @return boolean
     * @throws \Exception
     */
    public function update($model, $form)
    {
        try {
            $this->fill($model, $form);
            if ($this->repository->save($model)) {
                return true;
            }
        } catch (SaveModelException $e) {
            $form->addErrors($model->getErrors());
            throw $e;
        }
        return false;
    }

    public function process($transactionId)
    {

    }
}
