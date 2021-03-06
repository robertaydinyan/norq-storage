<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProduct */
/* @var $groupProducts app\modules\warehouse\models\NomenclatureProduct */
/* @var $qtyTypes app\modules\warehouse\models\NomenclatureProduct */
/* @var $tableTreeGroups app\modules\warehouse\models\NomenclatureProduct */

$this->title = 'Ստեղծել Ապրանքի Նոմենկլատուրա';
$this->params['breadcrumbs'][] = ['label' => 'Nomenclature Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding: 20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'groupProducts' => $groupProducts,
        'qtyTypes' => $qtyTypes,
        'tableTreeGroups'=> $tableTreeGroups,
    ]) ?>
    </div>
</div>
