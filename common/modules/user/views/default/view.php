<?php
/**
 * Файл шаблона view
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View $this
 * @var \common\modules\user\models\User $model
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('ch/user', 'View user');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ch/user', 'Users'), 'url' => ['index']];
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($model->name); ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="box-body">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'name',
                'email:email',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d.m.Y H:i'],
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:d.m.Y H:i'],
                ],
            ],
        ]); ?>

    </div>

    <div class="box-footer">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-warning" href="<?= Url::to(['update', 'id' => $model->id]); ?>">
                    <i class="fa fa-pencil"></i> <?= Yii::t('yii', 'Update'); ?>
                </a>
                <a class="btn btn-default" href="<?= Url::to(['index']); ?>">
                    <i class="fa fa-arrow-left"></i> <?= Yii::t('ch/all', 'Back'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
