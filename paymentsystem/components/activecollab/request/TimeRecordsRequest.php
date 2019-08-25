<?php
/**
 * Файл класса TimeRecordsRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\ResponseInterface;
use common\components\activecollab\response\TimeRecordsResponse;

/**
 * Класс для работы с временными записями работы над проектом
 *
 * @package common\components\activecollab\request
 */
class TimeRecordsRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = 'projects/{project_id}/time-records';
    /**
     * @var int|null Номер страницы
     */
    protected $pageNumber;

    /**
     * Конструктор класса для работы с временными записями работы произведенной над проектом
     *
     * @param integer $projectId
     * @param int $pageNumber
     */
    public function __construct($projectId, $pageNumber = null)
    {
        $this->pageNumber = $pageNumber;
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
        return new TimeRecordsResponse($status, $data);
    }
}