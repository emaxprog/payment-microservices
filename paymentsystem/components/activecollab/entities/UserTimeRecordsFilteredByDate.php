<?php
/**
 * Файл класса UserTimeRecordsFilteredByDateRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class UserTimeRecordsFilteredByDate extends Value
{
    /**
     * @var TimeRecord[]
     */
    public $time_records;

    /**
     * @var array
     */
    public $related;

    /**
     * @inheritdoc
     */
    protected function propertyList()
    {
        return [
            'time_records' => [
                'class' => TimeRecord::class,
                'type' => Value::TYPE_ARRAY
            ],
            'related' => [
                'class' => Related::class,
                'type' => Value::TYPE_OBJECT
            ],
        ];
    }
}