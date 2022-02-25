<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Կոմպլեկտացիա';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">
<nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <div id="w3-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <li class="nav-item"><a class="nav-link" href="/complectation">Կոմպլեկտացիա</a></li>
                <li class="nav-item"><a class="nav-link" href="/complectation-products">Կոմպլեկտավորման արտադրանք</a></li>
            </ul>
        </div>
    </nav>
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?> <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn  btn-info p-3" >Ստեղծել Կոմպլեկտացիա</a></h4>

    <?php Pjax::begin(); ?>
    <div style="padding:20px;" >
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'price',
            'name',
            'count',
            'created_at',
            //'warehouse_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Գործողություն'),
                'template' => '{view}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="far fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Դիտել'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                            'title' => Yii::t('app', 'Ջնջել'),
                            'class' => 'btn text-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                'method' => 'post',
                            ],
                        ]);
                    }

                ]
            ],
        ],
    ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div>
