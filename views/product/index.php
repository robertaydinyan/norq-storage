<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url;
use app\modules\warehouse\models\Warehouse;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\ProductSearch */
/* @var $model app\modules\warehouse\models\ProductSearch */
/* @var $physicalWarehouse app\modules\warehouse\models\ProductSearch */
/* @var $requestSearch app\modules\warehouse\models\ProductSearch */
/* @var $nProducts app\modules\warehouse\models\ProductSearch */
/* @var $users app\modules\warehouse\models\ProductSearch */
/* @var $address app\modules\warehouse\models\ProductSearch */
/* @var $regions app\modules\warehouse\models\ProductSearch */
/* @var $groups app\modules\warehouse\models\ProductSearch */
/* @var $rols app\modules\warehouse\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Ապրանքներ';
$this->params['breadcrumbs'][] = $this->title;


$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

$this->registerJsFile('@web/js/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/createProduct.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/libs/js/locations.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

?>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.2/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
<style>
    thead input {
        width: 100%;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
    }
</style>
<?php echo $this->render('/menu_dirs', array(), true)?>

<div class="group-product-index">
    <div class="d-flex justify-content-between align-items-center">
        <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
        <a href="/group-product/show-group-products"><small style="font-size:12px;" class="btn btn-info p-3">Խմբեր</small></a>
    </div>


<div class="product-index group-product-index" style="padding: 20px;">

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
  
        <table id="example" class="table table-hover" style="width:100%">

            <thead>
            <?php if (!empty($dataProvider['result'])) : ?>
            <tr>
                <th>Պահեստի անուն</th>
                <th>Ապրանքի անուն</th>
                <th>Ապրանքի Նկար</th>
                <th>Քանակ</th>
                <th>Ինդիվիդուալ</th>
            </tr>
            </thead>
            <tbody>
                
            <?php foreach ($dataProvider['result'] as $key => $products) : ?>
                <tr>
                     <td><?php if($products['type'] != 4){ echo $products['wname'];} else {
                        echo Warehouse::getContactAddressById($products['contact_address_id']);
                     } ?></td>
                    <td><?= $products['nomeclature_name'] ?></td>
                    <td><a target="_blank" href="<?= $products['img'] ?>" ><img width="100" src="<?= $products['img'] ?>"></a></td>
                    <?php if ($products['individual'] == 'false') : ?>
                        <td><?= $products['count_n_product'] ?> <?= $products['qtype'] ?></td>
                    <?php else : ?>
                        <td><a href="#" data-toggle="modal" data-target="#viewInfo" onclick="showInfo(<?= $products['nid'] ?>,<?php echo $products['id'];?>)"><?= $products['count_n_product'] ?> <?= $products['qtype'] ?> </a></td>
                    <?php endif; ?>
                      <td><?php if($products['individual']=='true'){ echo 'Այո';} else { echo 'Ոչ';} ?></td>
                </tr>
            <?php endforeach; ?>
   
            </tbody>
            <?php endif; ?>
         
        </table>
        <script>
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'csv',
                        className: 'csv'
                    },
                    {
                        text: 'excel',
                        className: 'excel'
                    },
                ],
                "oLanguage": {
                    "sSearch": "Որոնում "
                },
                "language": {
                    "paginate": {
                        "previous": "Նախորդ",
                        "next": "Հաջորդ",
                    }
                }
            } );
        </script>
</div>

</div>

<div class="modal fade" id="viewInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="mod-content"></div>
                </div>
            </div>

        </div>
    </div>


<script>
    function showInfo(id,wid){
    if(id){
        $.ajax({
            url: '/get-product-info',
            method: 'get',
            dataType: 'html',
            data: { id: id,wid:wid},
            success: function (data) {
                $('.mod-content').html(data);
            }
        });
    }
}
</script>