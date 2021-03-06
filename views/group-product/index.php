<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\ActiveQuery;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\GroupProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tableTreeGroups yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */

$this->title = 'Ապրանքի խումբ';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('@web/libs/css/datatable-jquery/fixedheader-datatable.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('@web/libs/css/datatable-jquery/jquery-datatable.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

$this->registerJsFile('@web/js/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/libs/js/table/datatables/jQuery-3.5.1.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/libs/js/table/datatables/jquery-datatables.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/libs/js/table/datatables/dataTables-fixedheader.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
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
<div class="group-product-index" >
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?> <p style="float: right;"><button class="btn btn-sm btn-info p-3"  onclick="addPopup(0)">Ստեղծել Ապրանքի խումբ</button></p></h4>
    <div style="display: flex">
        <div class="col-lg-12">
            <ul class="file-tree" style="padding: 30px;padding-top: 10px;margin-top:20px;">
                <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                    <li class="file-tree-folder" data-id="<?= $tableTreeGroup['id'] ?>"> <span data-name="<?= $tableTreeGroup['name'] ?>" class="parent-block"> <?= $tableTreeGroup['name'] ?>
                            <i class="fa fa-plus" onclick="addPopup(<?= $tableTreeGroup['id'] ?>)"></i>
                            <i style="margin-left:5px;" class="fa fa-pencil" onclick="editePopup(<?= $tableTreeGroup['id'] ?>,$(this))"></i>
                            <i style="margin-left:5px;" class="fa fa-trash" onclick="deletePopup(<?= $tableTreeGroup['id'] ?>,$(this))"></i>
                        </span>
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
    </div>
       <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="addGroup" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form method="post" action="">
                          <input type="hidden" name="_csrf" value="UvFGCxza780T3mp_WyLZazh2DQwueuKMsksAY0R7RqMdky1ic769q3mbKz0qa7ASb0UgfEo_jrjoH3U6HE8qzg==">
                          <label for="fname">Անվանում</label><br>
                          <input type="text" class="form-control" id="fname" name="name"><br>
                          <input type="hidden" id="group_id" name="group_id">
                          <button class="btn btn-success">Ավելացնել</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal fade" id="editeGroup" tabindex="-1" role="dialog" aria-labelledby="editeGroup" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form method="post" action="">
                        <input type="hidden" name="_csrf" value="UvFGCxza780T3mp_WyLZazh2DQwueuKMsksAY0R7RqMdky1ic769q3mbKz0qa7ASb0UgfEo_jrjoH3U6HE8qzg==">
                        <label for="fname">Անվանում</label><br>
                        <input type="text" class="form-control" id="fname__" name="name"><br>
                        <input type="hidden" id="id" name="id">
                        <button class="btn btn-success" type="submit" name="update_button">Պահպանել</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>