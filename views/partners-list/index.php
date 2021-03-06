<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchPartnersList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Գործընկերներ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="partners-list-index group-product-index">
    <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <div id="w3-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <li class="nav-item"><a class="nav-link" href="/qty-type">Չափման միավոր</a></li>
                <li class="nav-item"><a class="nav-link" href="/shipping-type">Տեղափոխության տեսակ</a></li>
                <li class="nav-item"><a class="nav-link" href="/status-list">Կարգավիճակներ</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse-types">Պահեստի տեսակներ</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse-groups">Վիրտուալ(տեսակներ)</a></li>
                <li class="nav-item"><a class="nav-link" href="/suppliers-list">Մատակարարներ</a></li>
                <li class="nav-item"><a class="nav-link" href="/partners-list">Գործընկերներ</a></li>
                <li class="nav-item"><a class="nav-link" href="/group-product">Ապրանքի խումբ</a></li>
                <li class="nav-item"><a class="nav-link" href="/nomenclature-product">Ապրանքի Նոմենկլատուրա</a></li>
            </ul>
        </div>
    </nav>
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-success" >Ստեղծել</a>
    </h4>
    <div style="padding:20px;" >
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                'title' => Yii::t('app', 'Թարմացնել'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                            'title' => Yii::t('app', 'Ջբջել'),
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

    <?php Pjax::end(); ?>
    </div>
</div>
