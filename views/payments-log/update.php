<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\QtyType */

$this->title = 'Փոփոխել Չափման միավորը: ' . $model->type;
$this->params['breadcrumbs'][] = ['label' => 'Qty Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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
