<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Պահեստ';
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?> <a style="float: right" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-success" >Ստեղծել Պահեստ</a></h4>
    <div style="padding:20px;" class="table">
        <table class="table">
            <?php foreach ($warehouse_types as $ware_type => $ware_type_val){ ?>
            <tr>
                <td><?php echo $ware_type_val->id;?></td>
                <td><a class="nav-link" href="<?= Url::to(['by-type']) ?>?type=<?php echo $ware_type_val->id;?>"><?php echo $ware_type_val->name;?></a></td>
                <td><a class="nav-link" href="<?= Url::to(['show-by-type']) ?>?type=<?php echo $ware_type_val->id;?>">Դիտել (<?php echo $ware_type_val->count;?>)</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
