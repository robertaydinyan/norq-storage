<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ShippingType */

$this->title = 'Ստեղծել տեղափոխության տեսակ';
$this->params['breadcrumbs'][] = ['label' => 'Shipping Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding:20px;" >

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
