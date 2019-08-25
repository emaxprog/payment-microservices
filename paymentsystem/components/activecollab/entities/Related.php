<?php
/**
 * Файл класса ProjectRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class Related extends Value
{
    /**
     * @var Project[]
     */
    public $project;
    /**
     * @var TaskList[]
     */
    public $task;


    /**
     * Свойства преобразуемые в объекты
     *
     * @return array
     */
    protected function propertyObject()
    {
        return [
            'project' => [
                'class' => Project::class,
                'type' => Value::TYPE_ARRAY
            ],
            'task' => [
                'class' => TaskList::class,
                'type' => Value::TYPE_ARRAY
            ],
        ];
    }
}