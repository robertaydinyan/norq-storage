<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ShippingRequest */
/* @var $shippingModel app\models\ShippingRequest */
/* @var $dataWarehouses app\models\ShippingRequest */
/* @var $nProducts app\models\ShippingRequest */
/* @var $dataUsers app\models\ShippingRequest */
/* @var $searchModel app\models\ShippingRequest */
/* @var $dataProvider app\models\ShippingRequest */

$this->title = 'Ստեղծել Ապրանքի տեղափոխություն';
$this->params['breadcrumbs'][] = ['label' => 'Shipping Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="shipping-product-create group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'shippingModel' => $shippingModel,
       // 'modelNProduct' => $modelNProduct,
        'dataWarehouses' => $dataWarehouses,
        'dataUsers'=>$dataUsers,
        'nProducts' => $nProducts,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
    </div>
</div>
