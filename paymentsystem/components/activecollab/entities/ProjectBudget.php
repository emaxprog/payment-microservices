<?php
/**
 * Файл класса ProjectBudgetRequest
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\components\activecollab\entities;

class ProjectBudget extends Value
{
    /**
     * @var integer
     */
    public $budget;
    /**
     * @var float
     */
    public $cost_so_far;
    /**
     * @var float
     */
    public $billable_cost_so_far;
    /**
     * @var integer
     */
    public $non_billable_cost_so_far;
    /**
     * @var CostByJobType[]
     */
    public $cost_by_job_type;

    /**
     * @inheritdoc
     */
    protected function propertyObject()
    {
        return [
            'cost_by_job_type' => [
                'class' => CostByJobType::class,
                'type' => Value::TYPE_ARRAY,
            ],
        ];
    }
}