<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\QtyType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qty-type-form">

    <?php $form = ActiveForm::begin(); ?>
     <div style="padding:20px;">
        <div>
            <?php foreach ($tableTreePartners as $tableTreePartner) : ?>
                <?php if($tableTreePartner['id'] != 7){
                    continue;
                } ?>
                    <ul style="display: block;" class="file-tree">
                        <?= \Yii::$app->view->renderFile('@app/views/payments-log/tree_table.php', [
                            'tableTreePartner' => $tableTreePartner,
                        ]); ?>
                    </ul>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    </div>
    <div style="padding-left: 15px;">
        <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-info mt-3 p-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
