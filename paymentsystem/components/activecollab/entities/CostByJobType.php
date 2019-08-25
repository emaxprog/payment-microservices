<?php
/**
 * Файл класса CostByJobType
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class CostByJobType extends Value
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var integer
     */
    public $rate;
    /**
     * @var float
     */
    public $hours;
    /**
     * @var integer
     */
    public $value;
    /**
     * @var integer
     */
    public $non_billable_hours;
    /**
     * @var integer
     */
    public $non_billable_value;
}