<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationProducts */

$this->title = 'Create Complectation Products';
$this->params['breadcrumbs'][] = ['label' => 'Complectation Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complectation-products-create">
    <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light ">
        <div id="w3-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <li class="nav-item"><a class="nav-link" href="/complectation">Կոմպլեկտացիա</a></li>
                <li class="nav-item"><a class="nav-link" href="/complectation-products">Կոմպլեկտավորման արտադրանք</a></li>
            </ul>
        </div>
    </nav>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
