<?php
/**
 * Файл класса ProjectBudgetRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\ResponseInterface;
use common\components\activecollab\response\ProjectBudgetResponse;

/**
 * Класс для работы с бюджетом проекта
 *
 * @package common\components\activecollab\request
 */
class ProjectBudgetRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = "projects/{project_id}/budget";

    /**
     * Конструктор класса для работы с бюджетом проекта
     *
     * @param $projectId
     */
    public function __construct($projectId)
    {
        $this->addTemplateParam('{project_id}', $projectId);
    }

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    public function buildResponse($status, $data)
    {
        return new ProjectBudgetResponse($status, $data);
    }
}