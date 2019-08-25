<?php
/**
 * Файл класса ProjectRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class Project extends Value
{
    /**
     * @var Single
     */
    public $single;
    /**
     * @var TaskList[]
     */
    public $task_lists;
    /**
     * @var array
     */
    public $category = [];
    /**
     * @var array
     */
    public $hourly_rates = [];
    /**
     * @var array
     */
    public $label_ids = [];

    /**
     * Свойства преобразуемые в объекты
     *
     * @return array
     */
    protected function propertyObject()
    {
        return [
            'single' => [
                'class' => Single::class,
                'type' => Value::TYPE_OBJECT
            ],
            'task_lists' => [
                'class' => TaskList::class,
                'type' => Value::TYPE_ARRAY
            ],
        ];
    }
}