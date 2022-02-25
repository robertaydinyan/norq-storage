<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Complectation */

$this->title = 'Թարմացնել : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Complectations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">
<nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <div id="w3-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <li class="nav-item"><a class="nav-link" href="/complectation">Կոմպլեկտացիա</a></li>
                <li class="nav-item"><a class="nav-link" href="/complectation-products">Կոմպլեկտավորման արտադրանք</a></li>
            </ul>
        </div>
    </nav>
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding: 20px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
