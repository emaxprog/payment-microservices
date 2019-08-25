<?php
/**
 * Файл класса PaymentJob
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\jobs;

use common\modules\paymentsystem\services\PaymentManagerService;
use Exception;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

/**
 * Class PaymentJob
 * @package common\modules\paymentsystem\jobs
 */
class PaymentJob extends BaseObject implements JobInterface
{
    /**
     * @var int
     */
    public $transactionId;
    /**
     * @var PaymentManagerService
     */
    protected $service;

    public function __construct(PaymentManagerService $service, $config = [])
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
        $this->service->payment($this->transactionId);
    }
}
