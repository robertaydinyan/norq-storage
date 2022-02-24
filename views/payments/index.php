<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchSuppliersList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Վճարումներ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<style>
    thead input {
        width: 100%;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
    }
    .fa-plus{
        color:#29a746;
    }
    .fa-trash{
        color:darkred;
    }
</style>
<div class="group-product-index">
   <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <div id="w3-collapse" class="collapse navbar-collapse">
        <ul id="w5" class="navbar-nav w-100 nav">
            <li class="nav-item"><a class="nav-link" href="/payments">ՎիՃակագրություն</a></li>
            <li class="nav-item"><a class="nav-link" href="/payments-log">Վճարումներ</a></li>
        </ul>
    </div>
</nav>
    <div style="padding:20px;">
        <div>
            <?php foreach ($tableTreePartners as $tableTreePartner) : ?>
                <?php if($tableTreePartner['id'] != 7){
                    continue;
                } ?>
                    <ul style="display: block;" class="file-tree">
                        <?= \Yii::$app->view->renderFile('@app/views/payments/tree_table.php', [
                            'tableTreePartner' => $tableTreePartner,
                        ]); ?>
                    </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<br>
<style>
    .file-tree .file-tree-folder::after{
        content: '' !important;
    }
    .file-tree-folder li{
        border-bottom: 2px solid lightgray;
    }
</style>