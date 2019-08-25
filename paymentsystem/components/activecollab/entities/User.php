<?php
/**
 * Файл класса Users
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class User extends Value
{
    /**
     * @var UserInformation
     */
    public $single;

    /**
     * @inheritdoc
     */
    protected function propertyList()
    {
        return [
            'single' => [
                'class' => UserInformation::class,
                'type' => UserInformation::TYPE_OBJECT
            ]
        ];
    }
}