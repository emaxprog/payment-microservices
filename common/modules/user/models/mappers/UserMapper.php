<?php
/**
 * Файл класса UserMapper
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\mappers;

use Yii;
use yii\db\Query;
use chulakov\components\base\SingletonTrait;
use chulakov\components\models\mappers\Mapper;
use chulakov\components\models\mappers\types\NullType;
use chulakov\components\models\mappers\types\ModelType;
use chulakov\components\validators\ClearMultibyteValidator;
use common\modules\user\models\forms\UserForm;
use common\modules\user\models\User;

class UserMapper extends Mapper
{
    use SingletonTrait;

    /**
     * @var UserForm
     */
    protected $form;

    /**
     * @inheritdoc
     */
    public function initFillAttributes()
    {
        return ['username', 'name', 'email'];
    }

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
    public function initModelRules()
    {
        return [
            [['username', 'name', 'email'], ClearMultibyteValidator::class],
            [['username', 'name'], 'required'],
            [['username', 'name', 'email'], 'string', 'max' => 255],
            [['username'], 'unique',
                'targetClass' => User::class,
                'message' => 'Пользователь с таким логином уже существует.',
                'filter' => function (Query $query) {
                    if ($this->form && $id = $this->form->getId()) {
                        $query->andWhere(['<>', 'id', $id]);
                    }
                }
            ],
            [['email'], 'unique',
                'targetClass' => User::class,
                'message' => 'Пользователь с таким e-mail уже существует.',
                'filter' => function (Query $query) {
                    if ($this->form && $id = $this->form->getId()) {
                        $query->andWhere(['<>', 'id', $id]);
                    }
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelLabels()
    {
        return [
            'id' => Yii::t('ch/all', 'ID'),
            'username' => Yii::t('ch/user', 'Username'),
            'password' => Yii::t('ch/user', 'Password'),
            'name' => Yii::t('ch/user', 'Name'),
            'email' => Yii::t('ch/user', 'E-mail'),
            'created_at' => Yii::t('ch/all', 'Created at'),
            'updated_at' => Yii::t('ch/all', 'Updated at'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function initFormLabels()
    {
        return array_merge(parent::initFormLabels(), [
            'password' => Yii::t('ch/user', 'Password'),
        ]);
    }
}
