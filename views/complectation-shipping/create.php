<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationShipping */
/* @var $complectationModel app\modules\warehouse\models\ComplectationShipping */
/* @var $dataWarehouses app\modules\warehouse\models\ComplectationShipping */
/* @var $dataUsers app\modules\warehouse\models\ComplectationShipping */
/* @var $nProducts app\modules\warehouse\models\ComplectationShipping */
/* @var $nProducts app\modules\warehouse\models\ComplectationShipping */

$this->title = 'Ստեղծել կոմպլեկտացիայի տեղափոխություն';
$this->params['breadcrumbs'][] = ['label' => 'Complectation Shippings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="complectation-shipping-create group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'complectationModel' => $complectationModel,
        'dataWarehouses' => $dataWarehouses,
        'dataUsers'=>$dataUsers,
        'nProducts' => $nProducts,
        'nProductsName' =>  $nProductsName,
    ]) ?>
    </div>
</div>
