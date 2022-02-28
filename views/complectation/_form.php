<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Complectation */
/* @var $model_products app\modules\warehouse\models\ComplectationProducts */
/* @var $dataWarehouses app\modules\warehouse\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/complectation.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

<div class="complectation-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'count')->input('number') ?>
            <?= $form->field($model, 'created_at')->textInput(['class'=>'datepicker form-control']) ?>
            <?= $form->field($model, 'warehouse_id', [
                'options' => ['class' => 'form-group provider_warehouse'],
            ])->widget(Select2::className(), [
                'theme' => Select2::THEME_KRAJEE,
                'data' => $dataWarehouses,
                'maintainOrder' => true,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => Yii::t('app', 'Ընտրել'),
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'disabled' => !$model->isNewRecord
                ],
            ]) ?>
        </div>
        <div class="shipping-request-form col-sm-6">
            <?php if($model->isNewRecord){ ?>
                <div class="hide-block"></div>
                <div id="deal-addresses"  class="module-service-form-card border-primary position-relative col-md-12 mt-3">
                    <div class="row product-block" >
                        <div class="col-sm-12 mt-3">
                            <?= $form->field($model_products, 'product_id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'data' => [],
                                'maintainOrder' => true,
                                'options' => [
                                    'id' => 'nomenclature_product',
                                    'class'=>'nm_products',
                                    'placeholder' => Yii::t('app', 'Ընտրել')
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $form->field($model_products, 'n_product_count[]', [
                                'options' => ['class' => 'form-group counts-input sk-floating-label'],
                                'template' => '{input}{label}{error}{hint}'
                            ])->textInput(['maxlength' => true,'type' => 'number','required'=>'required']) ?>
                        </div>
                        <div class="col-sm-4">
                            <div class="remove-address d-none float-right">
                                <span class="ui-btn ui-btn-xs ui-btn-danger card-action-btn-remove-address"><?= Yii::t('app', 'Ջնջել') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="add-address">
                        <span class="btn-add-product">Ավելացնել</span>
                    </div>
                </div>
            <?php }  ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-info check-counts mt-3 p-3']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
