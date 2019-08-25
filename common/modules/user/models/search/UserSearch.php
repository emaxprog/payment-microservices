<?php
/**
 * Файл класса UserSearch
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\search;

use Yii;
use yii\db\ActiveQuery;
use chulakov\components\models\search\SearchForm;
use common\modules\user\models\User;

class UserSearch extends SearchForm
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('ch/user', 'Name'),
            'username' => Yii::t('ch/user', 'Username'),
            'email' => Yii::t('ch/user', 'E-mail'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function applyFilter(ActiveQuery $query)
    {
        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);
    }

    /**
     * @inheritdoc
     */
    protected function buildSort()
    {
        return [
           'defaultOrder' => [
               'id' => SORT_ASC,
           ],
           'attributes' => ['id', 'name', 'username', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery()
    {
        return User::find();
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }
}
