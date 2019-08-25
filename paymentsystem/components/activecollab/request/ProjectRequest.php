<?php
/**
 * Файл класса ProjectRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\ProjectResponse;
use common\components\activecollab\response\ResponseInterface;

/**
 * Класс для работы с проектом
 *
 * @package common\components\activecollab\request
 */
class ProjectRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = 'projects/{project_id}';

    /**
     * Конструктор класса для работы с проектами
     *
     * @param integer $projectId
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
        return new ProjectResponse($status, $data);
    }
}