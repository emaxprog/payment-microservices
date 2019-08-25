<?php
/**
 * Файл класса RequestInterface
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\request;

use common\components\activecollab\response\ResponseInterface;

/**
 * Базовый интерфейс запросов
 *
 * @package common\components\activecollab\request
 */
abstract class RequestInterface
{
    /**
     * @var integer
     */
    protected $pageNumber;
    /**
     * @var string
     */
    protected $method;
    /**
     * @var array
     */
    protected $templateParams = [];

    /**
     * Формирование URL адреса запроса
     *
     * @return string
     */
    public function getUrlPath()
    {
        return strtr($this->method, $this->templateParams);
    }

    /**
     * Добавить шаблон
     *
     * @param string $template
     * @param string $value
     */
    public function addTemplateParam($template, $value)
    {
        $this->templateParams[$template] = $value;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->pageNumber;
    }

    /**
     * Подготовка массива запроса
     *
     * @return array
     */
    public function getParams()
    {
        return [];
    }

    /**
     * Подготовка ответа на запрос
     *
     * @param integer|string $status
     * @param array $data
     * @return ResponseInterface
     */
    abstract public function buildResponse($status, $data);
}
