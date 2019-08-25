<?php
/**
 * Файл класса UserForm
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\forms;

use chulakov\components\models\forms\Form;

class UserForm extends Form
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $email;
}
