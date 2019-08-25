<?php
/**
 * Файл класса UserRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class UserInformation extends Value
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
     * @var bool
     */
    public $is_archived;
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
    public $language_id;
    /**
     * @var string
     */
    public $first_name;
    /**
     * @var string
     */
    public $last_name;
    /**
     * @var string
     */
    public $display_name;
    /**
     * @var string
     */
    public $short_display_name;
    /**
     * @var string
     */
    public $email;
    /**
     * @var bool
     */
    public $is_email_at_example;
    /**
     * @var array
     */
    public $additional_email_addresses;
    /**
     * @var bool
     */
    public $is_pending_activation;
    /**
     * @var string
     */
    public $avatar_url;
    /**
     * @var array
     */
    public $custom_permissions;
    /**
     * @var integer
     */
    public $company_id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */
    public $im_type;
    /**
     * @var string
     */
    public $im_handle;
}