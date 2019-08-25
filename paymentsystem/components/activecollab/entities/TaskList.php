<?php
/**
 * Файл класса TaskList
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class TaskList extends Value
{
    /**
     * @var integer
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
     * @var integer
     */
    public $project_id;
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
    public $start_on;
    /**
     * @var integer
     */
    public $due_on;
    /**
     * @var integer
     */
    public $position;
    /**
     * @var integer
     */
    public $open_tasks;
    /**
     * @var integer
     */
    public $completed_tasks;
}