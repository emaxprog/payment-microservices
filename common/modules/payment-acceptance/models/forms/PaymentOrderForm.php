<?php
/**
 * Файл класса PaymentOrderForm
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\models\forms;

use chulakov\components\models\forms\Form;

class PaymentOrderForm extends Form
{
    /**
     * @var integer
     */
    public $user_id;
    /**
     * @var integer
     */
    public $sum;
}
