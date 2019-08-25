<?php
/**
 * Файл класса PaymentForm
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentsystem\models\forms;

use chulakov\components\models\forms\Form;

class PaymentForm extends Form
{
    /**
     * @var integer
     */
    public $sum;
    /**
     * @var double
     */
    public $commission;
    /**
     * @var integer
     */
    public $order_number;
}
