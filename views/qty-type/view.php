<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\QtyType */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Qty Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
\yii\web\YiiAsset::register($this);
?>
<div class="qty-type-view group-product-index">

    <h4 style="padding: 20px;">Քանակի տեսակ ։ <?= Html::encode($model->type) ?></h4>



    <div class="col-lg-4">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'type',
            ],
        ]) ?>
    </div>
    <p style="padding: 20px;">
        <?= Html::a('Փոփոխել', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a('Ջնջել', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
