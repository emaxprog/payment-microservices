<?php
/**
 * Файл класса Collection
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\models\data;

/**
 * Объект коллекции данных, хранящихся по ключу
 *
 * @package common\models\data
 */
class Collection implements \Iterator
{
    /**
     * @var array Массив коллекции данных
     */
    protected $data = [];

    /**
     * Конструктор базовых данных коллекции
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->setCollection($data);
    }

    /**
     * Получение элемента из коллекции
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->exist($key)) {
            return $this->data[$key];
        }
        if ($default instanceof static) {
            return $default->get($key);
        }
        return $default;
    }

    /**
     * Добавление в коллекцию элемента или его перезапись
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Добавление в коллекцию массива элементов
     *
     * @param array $data
     */
    public function setCollection($data)
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->set($key, $value);
            }
        }
    }

    /**
     * Добавление элемента в коллекцию.
     * Если элемент не является массивом, то элемент будет просто перезаписан.
     * Если элемент был создан как массив, то значение будет добавлено в список.
     *
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        if (!$this->exist($key) || !is_array($this->data[$key])) {
            $this->set($key, $value);
        } else {
            if (is_array($value)) {
                $this->set($key, array_merge($this->data[$key], $value));
            } else {
                $this->data[$key][] = $value;
            }
        }
    }

    /**
     * Проверка на существование элемента
     *
     * @param string $key
     * @return bool
     */
    public function exist($key)
    {
        return isset($this->data[$key]) || array_key_exists($key, $this->data);
    }

    /**
     * Получение всех ключей коллекции
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->data);
    }

    /**
     * Текущее значение
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * Перевод каретки к следующему элементу
     */
    public function next()
    {
        next($this->data);
    }

    /**
     * Получение текущего ключа
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * Валидность следующего элемента
     *
     * @return bool
     */
    public function valid()
    {
        return key($this->data) !== null;
    }

    /**
     * Сброс внутреннего указателя
     */
    public function rewind()
    {
        reset($this->data);
    }
}
