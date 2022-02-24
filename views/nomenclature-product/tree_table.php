<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<?php if(array_key_exists('children', $tableTreeGroup)) : ?>
    <?php foreach ($tableTreeGroup['children'] as $tableTreeGroup) : ?>
        <li class="file-tree-folder"> <span> <?= $tableTreeGroup['name'] ?></span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/views/nomenclature-product/tree_table.php', [
                    'tableTreeGroup' => $tableTreeGroup,
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>
<?php else : ?>
    <ul style="display: block;">
        <div class="form-row">
            <div class="c-checkbox">
                <input type="checkbox"
                       value= <?=$tableTreeGroup['id']; ?>
                       id="<?php echo $tableTreeGroup['id']; ?>"
                       class="form-control"
                       name="NomenclatureProduct[group_id]"
                >
                <label class="has-star" for="<?php echo $tableTreeGroup['id']; ?>"><?= Yii::t('app', 'Ընտրել') ?></label>
                <div class="help-block invalid-feedback"></div>
            </div>

        </div>
    </ul>
<?php endif; ?>
