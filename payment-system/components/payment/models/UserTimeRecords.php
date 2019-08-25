<?php

namespace common\components\payment\models;

use yii\di\Instance;
use common\components\payment\PaymentSystem;
use common\components\payment\entities\TimeRecords as TimeRecordsEntity;

/**
 * Файл класса UserTimeRecords
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */
class UserTimeRecords
{
    /**
     * @var integer Идентификатор пользователя
     */
    public $userId;
    /**
     * @var PaymentSystem|string
     */
    public $ac = 'activeCollab';
    /**
     * @var int Текущая страница
     */
    protected $pageNumber = 0;

    /**
     * UserTimeRecords constructor.
     *
     * @param integer $userId
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($userId)
    {
        $this->ac = Instance::ensure($this->ac);
        $this->userId = $userId;
    }

    /**
     * Получение номера текущей страницы
     *
     * @return int
     */
    public function currentPage()
    {
        return $this->pageNumber;
    }

    /**
     * Получение следующей страницы
     *
     * @throws \Exception
     */
    public function nextPage()
    {
        ++$this->pageNumber;
        return $this->getPage();
    }

    /**
     * Получить предыдущую с
     *
     * @return array|TimeRecordsEntity
     * @throws \Exception
     */
    public function backPage()
    {
        --$this->pageNumber;
        return $this->getPage();
    }

    /**
     * Получение страницы
     *
     * @return array|TimeRecordsEntity
     * @throws \Exception
     */
    public function getPage()
    {
        return $this->ac->getUserTimeRecords($this->userId, $this->pageNumber);
    }
}