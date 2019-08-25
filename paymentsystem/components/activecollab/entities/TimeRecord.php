<?php
/**
 * Файл класса TimeRecord
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class TimeRecord extends Value
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $class;
    /**
     * @var string
     */
    public $url_path;
    /**
     * @var boolean
     */
    public $is_trashed;
    /**
     * @var integer
     */
    public $trashed_on;
    /**
     * @var integer
     */
    public $trashed_by_id;
    /**
     * @var integer
     */
    public $billable_status;
    /**
     * @var float
     */
    public $value;
    /**
     * @var integer
     */
    public $record_date;
    /**
     * @var string
     */
    public $summary;
    /**
     * @var integer
     */
    public $user_id;
    /**
     * @var string
     */
    public $parent_type;
    /**
     * @var integer
     */
    public $parent_id;
    /**
     * @var integer
     */
    public $created_on;
    /**
     * @var integer
     */
    public $created_by_id;
    /**
     * @var integer
     */
    public $updated_on;
    /**
     * @var integer
     */
    public $updated_by_id;
    /**
     * @var integer
     */
    public $job_type_id;
    /**
     * @var int float
     */
    public $expenses = 0;
}