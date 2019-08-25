<?php
/**
 * Файл класса AuthenticateRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class Authenticate extends Value
{
    /**
     * @var string
     */
    public $is_ok;
    /**
     * @var string
     */
    public $token;
}