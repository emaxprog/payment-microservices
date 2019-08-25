<?php
/**
 * Файл класса ProjectBudgetRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\response;

use common\components\activecollab\entities\ProjectBudget;

/**
 * Класс для работы с ответом на запрос с бюджетом проекта
 *
 * @package common\components\activecollab\response
 */
class ProjectBudgetResponse extends ResponseInterface
{
    /**
     * Преобразование содержимого
     *
     * @return ProjectBudget
     */
    public function decode()
    {
        return new ProjectBudget($this->data);
    }
}