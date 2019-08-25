<?php
/**
 * Файл класса FilteredByDateRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\UserTimeRecordsFilteredByDateResponse;
use common\components\activecollab\response\ResponseInterface;

/**
 * Класс для работы с временной записью отфитрованной по диапазону даты
 *
 * @package common\components\activecollab\request
 */
class UserTimeRecordsFilteredByDateRequest extends RequestInterface
{
    /**
     * @var string
     */
    protected $method = 'users/{user_id}/time-records/filtered-by-date';
    /**
     * @var string
     */
    protected $from;
    /**
     * @var string
     */
    protected $to;

    /**
     * Конструктор класса для работы с проектами
     *
     * @param $userId
     * @param $from
     * @param $to
     * @param null $pageNumber
     */
    public function __construct($userId, $from, $to, $pageNumber = null)
    {
        $this->addTemplateParam('{user_id}', $userId);
        $this->pageNumber = $pageNumber;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Подготовка массива запроса
     *
     * @return array
     */
    public function getParams()
    {
        $request = [
            'from' => $this->from,
            'to' => $this->to,
        ];
        return $request;
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
        return new UserTimeRecordsFilteredByDateResponse($status, $data);
    }
}