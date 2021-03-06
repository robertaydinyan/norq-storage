<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WarehouseTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warehouse-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-info p-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
