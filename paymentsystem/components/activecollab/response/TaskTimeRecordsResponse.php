<?php
/**
 * Файл класса TaskTimeRecordsRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\response;

use common\components\activecollab\entities\TaskTimeRecords;

class TaskTimeRecordsResponse extends ResponseInterface
{
    /**
     * Преобразование данных
     *
     * @return TaskTimeRecords
     */
    public function decode()
    {
        return new TaskTimeRecords($this->data);
    }
}