<?php
/**
 * Файл класса ProjectRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\response;

use common\components\activecollab\entities\Project;

/**
 * Класс для работы с ответом на запрос на получение проекта
 *
 * @package common\components\activecollab\response
 *
 * @property string $single
 */
class ProjectResponse extends ResponseInterface
{
    /**
     * Преобразование содержимого
     *
     * @return Project
     */
    public function decode()
    {
        return new Project($this->data);
    }
}