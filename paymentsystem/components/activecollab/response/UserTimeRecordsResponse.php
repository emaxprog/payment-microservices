<?php
/**
 * Файл класса TaskTimeRecordsRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\response;

use common\components\activecollab\entities\TimeRecords;

class UserTimeRecordsResponse extends ResponseInterface
{
    /**
     * Преобразование данных
     *
     * @return TimeRecords
     */
    public function decode()
    {
        return new TimeRecords($this->data);
    }
}