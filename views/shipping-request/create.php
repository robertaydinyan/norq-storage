<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ShippingRequest */
/* @var $dataWarehouses app\models\ShippingRequest */
/* @var $nProducts app\models\ShippingRequest */
/* @var $dataUsers app\models\ShippingRequest */
/* @var $suppliers app\models\ShippingType */
/* @var $types app\models\ShippingType */
/* @var $partners app\models\PartnersList */
$this->title = 'Ստեղծել հարցում';
$this->params['breadcrumbs'][] = ['label' => 'Shipping Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="shipping-request-create group-product-index">
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'dataWarehouses' => $dataWarehouses,
        'dataUsers'=>$dataUsers,
         'types' => $types,
         'requests'=> $requests,
        'suppliers' => $suppliers,
        'partners' => $partners,
        'nProducts' => $nProducts
    ]) ?>
    </div>
</div>
