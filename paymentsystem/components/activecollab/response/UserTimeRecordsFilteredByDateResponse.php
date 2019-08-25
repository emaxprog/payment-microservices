<?php
/**
 * Файл класса FilteredByDateResponse
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\response;

use common\components\activecollab\entities\UserTimeRecordsFilteredByDate;

/**
 * Класс для работы с ответом на запрос на получение отфильтрованных по дате временных записей
 *
 * @package common\components\activecollab\response
 *
 * @property string $single
 */
class UserTimeRecordsFilteredByDateResponse extends ResponseInterface
{
    /**
     * Преобразование содержимого
     *
     * @return UserTimeRecordsFilteredByDate
     */
    public function decode()
    {
        return new UserTimeRecordsFilteredByDate($this->data);
    }
}