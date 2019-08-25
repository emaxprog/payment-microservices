<?php
/**
 * Файл класса IndexAction
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\controllers\api;

use chulakov\components\rest\actions\Action;
use common\modules\paymentsystem\services\PaymentManagerService;
use yii\web\BadRequestHttpException;

class IndexAction extends Action
{
    /**
     * @var PaymentManagerService
     */
    protected $service;

    /**
     * IndexAction constructor.
     * @param $id
     * @param $controller
     * @param PaymentManagerService $service
     * @param array $config
     */
    public function __construct($id, $controller, PaymentManagerService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $controller, $config);
    }

    /**
     * Выполнение действия получения фото
     *
     * @return array
     * @throws BadRequestHttpException
     */
    public function run()
    {
        try {
            return $this->service->emulatePayment();
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}