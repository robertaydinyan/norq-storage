<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchStatusList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ստատուսներ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?> <?= Html::a('Ստեղծել', ['create'], ['class' => 'btn btn-info p-3 float-right']) ?></h4>

    <div style="padding: 20px;">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => [
            'id',
            'name',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                'title' => Yii::t('app', 'Թարմացնել'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]);
                    }

                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div>
</div>
