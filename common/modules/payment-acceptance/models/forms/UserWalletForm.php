<?php
/**
 * Файл класса UserWalletForm
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\paymentacceptance\models\forms;

use chulakov\components\models\forms\Form;

class UserWalletForm extends Form
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
