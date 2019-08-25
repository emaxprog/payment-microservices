<?php
/**
 * Файл шаблона create
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View $this
 * @var \common\modules\user\models\forms\UserForm $model
 */

use yii\helpers\Url;

$this->title = Yii::t('ch/user', 'Create user');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ch/user', 'Users'), 'url' => ['index']];
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('ch/user', 'User form'); ?></h3>
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
                    <i class="fa fa-save"></i> <?= Yii::t('ch/all', 'Create'); ?>
                </button>
                <button type="submit" name="refresh" value="1" class="btn btn-success">
                    <i class="fa fa-save"></i> <?= Yii::t('ch/all', 'Create and continue'); ?>
                </button>
                <a class="btn btn-danger" href="<?= Url::to(['index']); ?>">
                    <i class="fa fa-ban"></i> <?= Yii::t('ch/all', 'Cancel'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
