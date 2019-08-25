<?php
/**
 * Файл класса UserWallet
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\entities;

use yii\base\BaseObject;

class UserWallet extends BaseObject
{
    /**
     * Идентификатор пользователя
     *
     * @var string
     */
    protected $user_id;
    /**
     * Сумма
     *
     * @var string
     */
    protected $sum;

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getSum()
    {
        return $this->sum;
    }
}