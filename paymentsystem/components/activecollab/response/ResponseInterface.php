<?php
/**
 * Файл класса ResponseInterface
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\response;

/**
 * Базовый класс ответа от сервера
 *
 * @package common\components\activecollab\response
 */
abstract class ResponseInterface
{
    /**
     * @var int|string
     */
    public $status;
    /**
     * @var array Разрешенные динамические атрибуты
     */
    public $keys = [];
    /**
     * @var array[] Массив динамических данных
     */
    protected $data = [];

    /**
     * Конструктор ответа сервера
     *
     * @param integer|string $status
     * @param array $data
     */
    public function __construct($status, $data)
    {
        $this->status = $status;
        $this->data = $data;
        $this->init();
    }

    /**
     * Инициализация данных модели из пришедших данных
     */
    public function init()
    {
    }

    /**
     * Преобразование содержимого
     *
     * @return array|array[]
     */
    public function decode()
    {
        return $this->data;
    }

    /**
     * Магический метод получения данных из запроса
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }
}