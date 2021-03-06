<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Product */
/* @var $imagesPaths app\modules\warehouse\models\Product */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
<?php echo $this->render('/menu_dirs', array(), true)?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'price',
            'retail_price',
            'supplier_name',
            'mac_address',
            'comment',
            'used',
            'created_at',
            'warehouse_id',
            'nomenclature_product_id',

        ],
    ]) ?>

    <?php if ($imagesPaths !== null) : ?>
        <?php foreach ($imagesPaths as $imagePath): ?>
            <img src="<?= $imagePath->images_path ?>" alt="" width="200" height="200">
        <?php endforeach; ?>
    <?php endif; ?>

</div>
