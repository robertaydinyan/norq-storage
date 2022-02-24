<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\ActiveQuery;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\GroupProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tableTreeGroups yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */

$this->title = 'Ապրանքներ';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('@web/css/plugins/datatable-jquery/fixedheader-datatable.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('@web/css/plugins/datatable-jquery/jquery-datatable.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/table/datatables/jQuery-3.5.1.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/table/datatables/jquery-datatables.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/table/datatables/dataTables-fixedheader.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
<style>
    thead input {
        width: 100%;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
    }
</style>

<div  class="group-product-index">
<?php echo $this->render('/menu_dirs', array(), true)?>
        <h4 style="padding: 20px;"><?= Html::encode($this->title) ?>
        <a href="/product"><small style="font-size:12px;" class="btn btn-success">Պահեստներ</small></a>
        <a style="float: right;" class="btn btn-sm btn-primary" data-toggle="collapse" href="#search_" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-search"></i></a>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-success btn-sm" >Ստեղծել</a>
    </h4>

    <div style="clear: both;"></div>
    <div class="row">
        <div class="col-lg-3" style="padding: 40px;">
            <ul class="file-tree" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
                <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                    <li class="file-tree-folder"> <span> <?= $tableTreeGroup['name'] ?></span>
                        <ul style="display: block;">
                            <?= \Yii::$app->view->renderFile('@app/views/group-product/tree_table.php', [
                                'tableTreeGroup' => $tableTreeGroup,
                                'groupProducts' => $groupProducts
                            ]); ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-lg-9">
            <br>
    <table id="products" class="table table-bordered" style="width:100%;background: white;">
    <thead>
    <tr>
        <th>Անուն</th>
        <th>Գին</th>
        <th>Քանակ</th>
        <th>Մատակարար</th>
        <th>Մեկնաբանություն</th>
        <th>Ինդիվիդուալ</th>
        <th>Պահեստի Տեսակ</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($haveProducts as $products) : ?>
        <tr>
            <td><?= $products['n_product_name'] ?></td>
            <td><?= number_format($products['price'],0,'.',','); ?> Դր․</td>
            <td><?=$products['count'] ?></td>
            <td><?= $products['supplier_name'] ?></td>
            <td><?= $products['comment'] ?></td>
            <td><?= $products['mac_address'] ?></td>
            <td><?= $products['warehouse_type'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>

</table>
</div>
    </div>
</div>