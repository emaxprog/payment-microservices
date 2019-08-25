<?php
/**
 * Файл шаблона поиска
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View $this
 * @var \common\modules\user\models\search\UserSearch $searchModel
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= \Yii::t('ch/all', 'Filters'); ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'username', [
                    'labelOptions' => [
                        'class' => 'control-label sr-only',
                    ],
                ])->textInput([
                    'placeholder' => $model->getAttributeLabel('username'),
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'email', [
                    'labelOptions' => [
                        'class' => 'control-label sr-only',
                    ],
                ])->textInput([
                    'placeholder' => $model->getAttributeLabel('email'),
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'name', [
                    'labelOptions' => [
                        'class' => 'control-label sr-only',
                    ],
                ])->textInput([
                    'placeholder' => $model->getAttributeLabel('name'),
                ]); ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-search"></i> <?= \Yii::t('ch/all', 'Search'); ?>
        </button>
        <a class="btn btn-default" href="<?= Url::to(['index']); ?>">
            <i class="fa fa-times"></i> <?= \Yii::t('ch/all', 'Reset'); ?>
        </a>
    </div>
</div>
