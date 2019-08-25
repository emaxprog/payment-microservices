<?php
/**
 * Файл класса Single
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class Single extends Value
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $url_path;
    /**
     * @var string
     */
    public $name;
    /**
     * @var integer
     */
    public $completed_on;
    /**
     * @var integer
     */
    public $completed_by_id;
    /**
     * @var bool
     */
    public $is_completed;
    /**
     * @var array
     */
    public $members;
    /**
     * @var integer
     */
    public $category_id;
    /**
     * @var string
     */
    public $label_id;
    /**
     * @var bool
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
     * @var string
     */
    public $body;
    /**
     * @var string
     */
    public $body_formatted;
    /**
     * @var string
     */
    public $company_id;
    /**
     * @var integer
     */
    public $leader_id;
    /**
     * @var integer
     */
    public $currency_id;
    /**
     * @var integer
     */
    public $template_id;
    /**
     * @var string
     */
    public $based_on_type;
    /**
     * @var integer
     */
    public $based_on_id;
    /**
     * @var string
     */
    public $email;
    /**
     * @var bool
     */
    public $is_tracking_enabled;
    /**
     * @var bool
     */
    public $is_client_reporting_enabled;
    /**
     * @var integer
     */
    public $budget;
    /**
     * @var integer
     */
    public $count_tasks;
    /**
     * @var integer
     */
    public $count_discussions;
    /**
     * @var integer
     */
    public $count_files;
    /**
     * @var integer
     */
    public $count_notes;
    /**
     * @var integer
     */
    public $last_activity_on;
}