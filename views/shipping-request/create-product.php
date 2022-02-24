<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $nProducts app\models\Product */
/* @var $physicalWarehouse app\models\Product */
/* @var $modelNProduct app\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $groupProducts app\models\Product */
/* @var $qtyTypes app\models\Product */
/* @var $tableTreeGroups app\models\Product */

$this->registerCssFile('@web/css/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/createProduct.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

?>

<div class="row product-form module-service-form-card" style="position:relative;">
    <div class="col-sm-4">
        <div class="form-group field-product-nomenclature_product_id required">
            <label class="control-label" for="product-nomenclature_product_id">Ապրանք</label>
            <select  class="form-control product-nomenclature_product_id select2" name="Product[nomenclature_product_id][]" >
                <option value="" >Ընտրել</option>
                <?php if($nProducts){ foreach ($nProducts as $np => $np_val){ ?>
                    <option value="<?php echo $np;?>"><?php echo $np_val;?></option>
                <?php }} ?>
            </select>
        </div>
        <div class="form-group field-product-price">
            <label class="control-label" for="product-price">Գին</label>
            <input type="number"  class="form-control price__" onchange="showTotal($(this))" name="Product[price][]" autocomplete="off">
        </div>
        <input type="hidden"  class="form-control" name="Product[retail_price][]" autocomplete="off">
    </div>
    <div class="col-sm-4">

        <div class="form-group field-product-comment">
            <label class="control-label" for="product-comment">Մեկնաբանություն</label>
            <input type="text" id="product-comment" class="form-control" name="Product[comment][]" maxlength="255" novalidate autocomplete="off">
        </div>
        <div class="form-group field-product-count">
            <label class="control-label" for="product-count">Քանակ</label>
            <input type="text"  class="form-control product-count" onchange="showTotal($(this))" name="Product[count][]" autocomplete="off">
        </div>
       
    </div>
    <div class="col-lg-4">
        <div class="rem" style="position: absolute;right:-5px;top:-20px;" onclick="$(this).closest('.product-form').remove()"><i style="color:red;font-size:30px;" class="fa fa-times"></i></div>
        <div class="form-group field-product-mac_address hide">
            <label class="control-label" for="product-count">Mac հասցե</label>
            <div class="row cloned-mac">
                <div class="col-sm-9">
                    <input type="text"  class="form-control mac" name="Product[mac_address][0][]">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-success btn-sm clone-mac" type="button"><i class="fa fa-plus"></i></button>
                </div>
                <div class="col-sm-1 hide" style="margin-left:5px;">
                    <button class="btn btn-danger btn-sm remove-mac" onclick="$(this).closest('.cloned-mac').remove()" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>
        <input type="hidden" name="Product[notice_if_move][]" class="is_vip" value="0">
         <div class="form-group field-product-count">
            <label class="control-label" for="product-count">Ընդանուր</label>
            <input type="text"  class="form-control product-price-total" onchange="showTotal($(this))" autocomplete="off">
        </div>
    </div>
    <div class="col-sm-12">
        <button class="btn btn-success clone-product" type="button"><i class="fa fa-plus"></i></button>
    </div>
</div>

<script>
        function showTotal(el_){
           var ct = el_.closest('.product-form').find('.product-count').val();
           var pr = el_.closest('.product-form').find('.product-price-total').val();
           var tot = el_.closest('.product-form').find('.price__').val();
           if(ct && pr){
            el_.closest('.product-form').find('.price__').val(pr/ct);
           } else if(tot && pr){
            el_.closest('.product-form').find('.product-count').val(pr/tot);
           } else if(tot && ct){
              el_.closest('.product-form').find('.product-price-total').val(tot*ct);
           }
        }
        $('body').on('change','.product-nomenclature_product_id',function(){
            var pId = $(this).val();
            var th_ = $(this);
            if($('#shippingrequest-shipping_type').val() != 5){
                if(pId) {
                    $.ajax({
                        url: '/product/get-product-info',
                        method: 'get',
                        dataType: 'json',
                        data: {id: pId},
                        success: function (data) {
                            if(data.individual == 'true'){
                                th_.closest('.product-form').find('.field-product-mac_address').show();
                                th_.closest('.product-form').find('.product-count').val(1).closest('.field-product-count').hide();
                                th_.closest('.product-form').find('.is_vip').val(1);
                            } else {
                                th_.closest('.product-form').find('.field-product-mac_address').hide();
                                th_.closest('.product-form').find('.product-count').val('').closest('.field-product-count').show();
                                th_.closest('.product-form').find('.is_vip').val(0);
                            }
                        }
                    });
                }
            }
        });

</script>