<?php
/**
 * Файл шаблона index
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\modules\user\models\search\UserSearch $searchModel
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\user\models\User;

$this->title = Yii::t('ch/user', 'Users');

?>

<div class="row">
    <div class="col-md-9">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('ch/all', 'List'); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">
                <?php $grid = GridView::begin([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'username',
                        'name',
                        'email:email',
                        [
                            'attribute' => 'created_at',
                            'format' => ['date', 'php:d.m.Y H:i'],
                        ],
                        [
                            'class' => 'chulakov\components\widgets\ActionColumn',
                        ],
                    ],
                    'layout' => '{items}',
                    'options' => [
                        'class' => 'grid-view table-responsive',
                    ],
                ]);
                $grid::end(); ?>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-success" href="<?= Url::to(['create']); ?>">
                            <i class="fa fa-plus"></i> <?= Yii::t('ch/all', 'Create'); ?>
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <?= $grid->renderPager(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>
