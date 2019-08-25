<?php
/**
 * Файл класса TimeRecordsRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class TimeRecords extends Value
{
    /**
     * @var TimeRecord[]
     */
    public $time_records;

    /**
     * @inheritdoc
     */
    protected function propertyList()
    {
        return [
            'time_records' => [
                'class' => TimeRecord::class,
                'type' => Value::TYPE_ARRAY
            ]
        ];
    }
}