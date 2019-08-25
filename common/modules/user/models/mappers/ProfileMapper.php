<?php
/**
 * Файл класса ProfileMapper
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\mappers;

use chulakov\components\models\mappers\Mapper;
use chulakov\components\models\mappers\types\ModelType;
use chulakov\components\models\mappers\types\NullType;
use chulakov\components\validators\ClearMultibyteValidator;
use common\modules\user\models\User;

class ProfileMapper extends Mapper
{

    /**
     * @inheritdoc
     */
    public function initAcceptedModelTypes()
    {
        return [
            new NullType(),
            new ModelType(User::class),
        ];
    }

    /**
     * @inheritdoc
     */
    public function initFillAttributes()
    {
        return [
            'name', 'email',
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelRules()
    {
        return [
            [['name', 'email'], ClearMultibyteValidator::class],
            [['name', 'email'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelLabels()
    {
        return [
            'name' => \Yii::t('ch/user', 'Name'),
            'email' => \Yii::t('ch/user', 'E-mail'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function initFormRules()
    {
        return array_merge(parent::initFormRules(), [
            [['password', 'confirm'], 'string'],
            ['confirm', 'compare', 'compareAttribute' => 'password'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function initFormLabels()
    {
        return array_merge(parent::initFormLabels(), [
            'password' => \Yii::t('ch/user', 'Password'),
            'confirm' => \Yii::t('ch/user', 'Confirm password'),
        ]);
    }
}
