<?php
/**
 * Файл класса PaymentOrderJob
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\jobs;

use common\modules\paymentacceptance\services\PaymentOrderService;
use Exception;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

/**
 * Class PaymentOrderJob
 * @package common\modules\paymentsystem\jobs
 */
class PaymentOrderJob extends BaseObject implements JobInterface
{
    /**
     * @var int
     */
    public $transactionId;
    /**
     * @var PaymentOrderService
     */
    protected $service;

    public function __construct(PaymentOrderService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    /**
     * Выполнение задания
     *
     * @param Queue $queue
     * @return mixed
     * @throws Exception
     */
    public function execute($queue)
    {
        $this->service->process($this->transactionId);
    }
}
