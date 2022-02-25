<?php

use app\models\Warehouse;
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
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding:20px;" class="table">
        <table class="table">
            <?php foreach ($regions as $region => $region_val){ ?>
                <tr>
                    <td><?php echo $region_val->id;?></td>
                    <td><a class="nav-link" href="<?= Url::to(['by-type']) ?>?type=<?php echo $type;?>&region=<?php echo $region_val->id;?>"><?php echo $region_val->name;?></a></td>
                    <td><a class="nav-link" href="<?= Url::to(['show-by-type']) ?>?type=<?php echo $type;?>&region=<?php echo $region_val->id;?>">Դիտել (<?php echo Warehouse::getCountByRegion($type,$region_val->id);?>)</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>