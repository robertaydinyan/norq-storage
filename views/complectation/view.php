<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Complectation */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Complectations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.2/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<div class="group-product-index">
<nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <div id="w3-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <li class="nav-item"><a class="nav-link" href="/complectation">????????????????????????</a></li>
                <li class="nav-item"><a class="nav-link" href="/complectation-products">?????????????????????????????? ??????????????????</a></li>
            </ul>
        </div>
    </nav>
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>

    <div style="padding:20px;" >
        <div class="row">
            <div class="col-sm-4">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'price',
                        'name',
                        'count',[
                            'label' => '???????????????? ??',
                            'value' => function ($model) {
                                return date('d.m.Y',strtotime($model->created_at));
                            }
                        ],
                        'warehouse_id',
                    ],
                ]) ?>
            </div>
            <div class="col-sm-7" style="margin-left: 50px;margin-top:50px;">
                <table id="products" class="display nowrap" style="width:100%;">
                    <thead>
                    <?php if (!empty($whProducts)) : ?>
                    <tr>
                        <th>??????????</th>
                        <th>??????????</th>
                        <th>??????????</th>
                        <th>??????????????????????</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($whProducts as $products) : ?>

                        <tr>
                            <td><?= $products['nProduct']['name'] ?></td>
                            <?php if ($products['nProduct']['individual'] == 'false') : ?>
                                <td><?= $products['n_product_count'] ?> <?= $products['nProduct']['qtyType']['type'] ?></td>
                            <?php else : ?>
                                <td><a href="#"  onclick="showLog('<?= $products->product['mac_address']?>')"><?= $products['n_product_count'] ?> <?= $products['nProduct']['qtyType']['type'] ?> </a></td>
                            <?php endif; ?>
                            <td  onclick="showLog('<?= $products->product['mac_address']?>')"><?= $products->product['mac_address']?></td>
                            <td><?php if($products['nProduct']['individual']=='true'){ echo '??????';} else { echo '????';} ?></td>
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

</div>
  <?php if (!empty($whProducts)) : ?>
     <script>
            $('#products').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                     'csv', 'excel'
                ],
                "oLanguage": {
                    "sSearch": "?????????????? "
                },
                "language": {
                    "paginate": {
                        "previous": "????????????",
                        "next": "????????????",
                    }
                }
            } );
        </script>
        <?php endif; ?>