<?php
/**
 * Файл класса TaskTimeRecordsRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\ResponseInterface;
use common\components\activecollab\response\TaskTimeRecordsResponse;

/**
 * Класс для работы с временными записями работы над проектом
 *
 * @package common\components\activecollab\request
 */
class TaskTimeRecordsRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = 'projects/{project_id}/tasks/{task_id}/time-records';

    /**
     * Конструктор класса для работы с временными записями работы произведенной над проектом
     *
     * @param integer $projectId
     * @param integer $taskId
     */
    public function __construct($projectId, $taskId)
    {
        $this->addTemplateParam('{project_id}', $projectId);
        $this->addTemplateParam('{task_id}', $taskId);
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
        return new TaskTimeRecordsResponse($status, $data);
    }
}