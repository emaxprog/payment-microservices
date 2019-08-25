<?php
/**
 * Файл шаблона update
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View $this
 * @var \common\modules\user\models\forms\UserForm $model
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('ch/user', 'Update user');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ch/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
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
        <?= $this->render('_form', [
            'model' => $model,
        ]); ?>
    </div>

    <div class="box-footer">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> <?= Yii::t('ch/all', 'Save'); ?>
                </button>
                <button type="submit" name="refresh" value="1" class="btn btn-success">
                    <i class="fa fa-save"></i> <?= Yii::t('ch/all', 'Apply'); ?>
                </button>
                <a class="btn btn-danger" href="<?= Url::to(['index']); ?>">
                    <i class="fa fa-ban"></i> <?= Yii::t('ch/all', 'Cancel'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
