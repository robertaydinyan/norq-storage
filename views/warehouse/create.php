<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Warehouse */
/* @var $address app\models\Warehouse */
/* @var $dataUsers app\models\Warehouse */
/* @var $warehouse_types app\models\Warehouse */

$this->title = 'Ստեղծել Պահեստ';
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'dataUsers'=>$dataUsers,
        'address' => $address,
        'warehouse_types' => $warehouse_types,
        'warehouse_groups' => $warehouse_groups,
        'countries' => $countries
    ]) ?>
    </div>
</div>
