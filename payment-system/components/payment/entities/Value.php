<?php
/**
 * Файл класса Value
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\payment\entities;

use yii\base\Arrayable;

/**
 * Базовый класс свойства
 *
 * @package common\models\values
 */
abstract class Value implements Arrayable
{
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'objects';

    /**
     * @var array Базовые данные настройка
     */
    protected $values = [];

    /**
     * Установка свойст модели
     *
     * @param array $values
     */
    public function __construct($values)
    {
        if (is_array($values)) {
            $this->values = $values;
        }
        $this->init();
    }

    /**
     * Инициализация полей
     */
    public function init()
    {
        $property = $this->propertyObject();
        foreach ($this->values as $key => $value) {
            if (property_exists($this, $key)) {
                if (isset($property[$key])) {
                    $value = $this->makePropertyObject(
                        $property[$key], $value
                    );
                }
                $this->{$key} = $value;
            }
        }
        $fields = array_keys($this->values);
        $this->values = array_combine($fields, $fields);
    }

    /**
     * Проверка наличия ранее установленного поля
     *
     * @param string $key
     * @return bool
     */
    public function hasProperty($key)
    {
        return array_key_exists($key, $this->values);
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return $this->values;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $values = [];
        if (empty($fields)) {
            $fields = $this->fields();
        }
        foreach ($fields as $field) {
            $values[$field] = $this->{$field};
        }
        return $values;
    }

    /**
     * Свойства преобразуемые в объекты
     *
     * @return array
     */
    protected function propertyObject()
    {
        return [];
    }

    /**
     * Проверяет, является ли свойство списком объектов
     *
     * @return array
     */
    protected function propertyList()
    {
        return [];
    }

    /**
     * Создание объекта
     *
     * @param string $object
     * @param array $value
     * @return Value|Value[]
     */
    protected function makePropertyObject($object, $value)
    {
        if (is_array($object) && $this->hasObjectProperty($object)) {
            if ($object['type'] === static::TYPE_ARRAY) {
                return $this->getInitObjects($object['class'], $value);
            }
        }
        return new $object['class']($value);
    }

    /**
     * Проверка на наличие
     *
     * @param $object
     * @return bool
     */
    protected function hasObjectProperty($object)
    {
        return isset($object['class'], $object['type']);
    }

    /**
     * Получить инициализированный массив объектов
     *
     * @param string $class
     * @param array $values
     * @return array
     */
    protected function getInitObjects($class, $values)
    {
        $result = [];
        foreach ($values as $key => $item) {
            $result[$key] = new $class($item);
        }
        return $result;
    }
}