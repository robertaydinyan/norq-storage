<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Warehouse */
/* @var $dataProvider app\models\Warehouse */
/* @var $searchModel app\models\Warehouse */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

?>
<?php echo $this->render('/menu_dirs', array(), true)?>
 
   <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<style>
    thead input {
        width: 100%;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
    }
</style>
<div class="warehouse-view d-flex group-product-index" style="padding: 20px;">
    <div class="col-lg-4">
        <h4><?= Html::encode($model->name) ?> (Պահեստ)</h4>
        <?php if($model->type != 2){ ?>
        <?= DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table table-bordered detail-view table-hover',
            ],
            'attributes' => [
                'name',
                [
                    'label' => 'Պահեստի տեսակը',
                    'value' => $model->getType($model->type)->name
                ],
                [
                    'label' => 'Պահեստապետ',
                    'value' => function ($model) {
                        $user = $model->getUser($model->responsible_id);
                        return $user->name.' '.$user->last_name;
                    }
                ],
                [
                    'label' => 'Երկիր',
                    'value' => function ($model) {
                        return $model->contactAddress->country->name;
                    }
                ],
                [
                    'label' => 'Մարզ',
                    'value' => function ($model) {
                        return $model->contactAddress->region->name;
                    }
                ],
                [
                    'label' => 'Քաղաք',
                    'value' => function ($model) {
                        return $model->contactAddress->city->name;
                    }
                ],
                [
                    'label' => 'Փողոց',
                    'value' => function ($model) {
                        return $model->contactAddress->fastStreet->name;
                    }
                ],

                [
                    'label' => 'Տուն',
                    'value' => function ($model) {
                        return $model->contactAddress->house;
                    }
                ],
                [
                    'label' => 'Ստեղծվել է',
                    'value' => function ($model) {
                        return date('d.m.Y',strtotime($model->created_at));
                    }
                ],
            ],
        ]) ?>
        <?php } else {
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    [
                        'label' => 'Պահեստի տեսակը',
                        'value' => $model->getType($model->type)->name
                    ],
                    [
                        'label' => 'Պահեստապետ',
                        'value' => function ($model) {
                            $user = $model->getUser($model->responsible_id);
                            return $user->name . ' ' . $user->last_name;
                        }
                    ],
                    'created_at',
                ],
            ]);
        } ?>
        <?php if(\Yii::$app->user->can('admin')){ ?>
        <p>
            <?= Html::a('Փոփոխել', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Ջնջել', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
       <?php } ?>
    </div>
    <div class="col-lg-7" style="margin-left: 50px;margin-top:50px;">
        <table id="datatable" class="display nowrap datatable" style="width:100%;">
            <thead>
            <?php if (!empty($whProducts)) : ?>
            <tr>
                <th>Ապրանքի Նկար</th>
                <th>Անուն</th>
                <th>Քանակ</th>
                <th>Ինդիվիդուալ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($whProducts as $products) : ?>
                <?php if($products['count_n_product']<=0){
                    continue;
                } ?>
                <tr>
                     <td><a target="_blank" href="<?= $products['nProduct']['img'] ?>" ><img width="100" src="<?= $products['nProduct']['img'] ?>"></a></td>
                    <td><?= $products['nProduct']['name'] ?></td>
                    <?php if ($products['nProduct']['individual'] == 'false') : ?>
                        <td><?= $products['count_n_product'] ?> <?= $products['nProduct']['qtyType']['type'] ?></td>
                    <?php else : ?>
                        <td><a href="#" data-toggle="modal" data-target="#viewInfo" onclick="showInfo(<?= $products['nProduct']['id'] ?>,<?php echo $model->id;?>)"><?= $products['count_n_product'] ?> <?= $products['nProduct']['qtyType']['type'] ?> </a></td>
                    <?php endif; ?>
                      <td><?php if($products['nProduct']['individual']=='true'){ echo 'Այո';} else { echo 'Ոչ';} ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <?php endif; ?>

        </table>
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


    </div>


</div>

</div>
<script>
    function showInfo(id,wid){
    if(id){
        $('.hide-block').hide();
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

 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.2/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
     <?php if (!empty($whProducts)) : ?>
     <script>
            $('#datatable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                     'csv', 'excel'
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
        <?php endif; ?>