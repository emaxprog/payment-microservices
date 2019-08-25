<?php
/**
 * Файл класса Property
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\models\data;

use yii\base\Arrayable;
use yii\helpers\Json;

/**
 * Базовый класс свойства
 *
 * @package common\models\values
 */
abstract class Property implements Arrayable
{
    /**
     * @var array Исходные данные объекта
     */
    protected $values = [];
    /**
     * @var array Список инициализированных полей
     */
    protected $fields = [];

    /**
     * Установка свойств модели
     *
     * @param array|string $values
     */
    public function __construct($values)
    {
        if (is_string($values)) {
            $values = Json::decode($values);
        }
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
        $propertyList = $this->propertyList();
        foreach ($this->values as $key => $value) {
            if (property_exists($this, $key)) {
                if (isset($property[$key])) {
                    $value = $this->makePropertyObject(
                        $property[$key], $value, in_array($key, $propertyList)
                    );
                }
                $this->{$key} = $value;
            }
        }
        $fields = array_keys($this->values);
        $this->fields = array_combine($fields, $fields);
    }

    /**
     * Проверка наличия ранее установленного поля
     *
     * @param string $key
     * @return bool
     */
    public function hasProperty($key)
    {
        return array_key_exists($key, $this->fields);
    }

    /**
     * Расширение списка инициализированных полей для расширение списка экспорта
     *
     * @param string $key
     */
    public function addProperty($key)
    {
        $this->fields[$key] = $key;
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return $this->fields;
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
        // Базовые свойства
        $fields = $fields ?: $this->fields();
        foreach ($fields as $field) {
            $values[$field] = $this->{$field};
        }
        // Расширенный список свойств
        $expand = $expand ?: $this->extraFields();
        foreach ($expand as $field) {
            if (property_exists($this, $field) && !empty($this->{$field})) {
                $values[$field] = $this->{$field};
            }
        }
        // Рекурсивный обход вложенных объектов
        if ($recursive) {
            foreach ($values as $field => $value) {
                if ($value instanceof Arrayable) {
                    $values[$field] = $value->toArray();
                }
            }
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
     * Свойства являющиеся списком объектов
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
     * @param string $class
     * @param array $value
     * @param boolean $asList
     * @return Property|Property[]
     */
    protected function makePropertyObject($class, $value, $asList = false)
    {
        if ($asList) {
            $result = [];
            foreach ($value as $key => $item) {
                $result[$key] = new $class($item);
            }
            return $result;
        }
        return new $class($value);
    }
}
