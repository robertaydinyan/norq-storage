<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShippingProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ապրանքի տեղափոխություն';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<?php echo $this->render('/menu_dirs', array(), true)?>

<div class="shipping-product-index group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?>
        <a style="float: right" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-success" >Ստեղծել Ապրանքի տեղափոխություն</a>
    </h4>
    <div style="padding:20px;">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'providerWarehouse',
                'label' => 'Առաքող պահեստ',
                'value' => function ($model) {
                    return $model->shipping->fromWarehouse->name;
                }
            ],
            [
                'attribute' => 'supplierWarehouse',
                'label' => 'Ստացող պահեստ',
                'value' => function ($model) {
                    return $model->shipping->toWarehouse->name;
                }
            ],
            [
                'attribute' => 'name',
                'label' => 'Անուն',
                'value' => function ($model) {
                    return $model->product->nProduct->name;
                }
            ],
            [
                'attribute' => 'mac_address',
                'label' => 'Mac հասցե',
                'value' => function ($model) {
                    return $model->product->mac_address;
                }
            ],
            [
                'attribute' => 'count',
                'label' => 'Քանակ',
                'value' => function ($model) {
                    return $model->count;
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Ստեղծվել է',
                'value' => function ($model) {
                    return $model->created_at;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Հղում'),
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="far fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Դիտել'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]);
                    },

//                    'update' => function ($url, $model) {
//                        return
//                            Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
//                                'title' => Yii::t('app', 'Թարմացնել'),
//                                'class' => 'btn text-primary btn-sm mr-2'
//                            ]);
//                    },
//                    'delete' => function ($url, $model) {
//                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
//                            'title' => Yii::t('app', 'Ջբջել'),
//                            'class' => 'btn text-danger btn-sm',
//                            'data' => [
//                                'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
//                                'method' => 'post',
//                            ],
//                        ]);
//                    }

                ]
            ],
        ],
    ]); ?>

    </div>
</div>
