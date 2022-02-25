<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_complectation".
 *
 * @property int $id
 * @property float|null $price
 * @property string|null $name
 * @property int|null $count
 * @property string|null $created_at
 * @property int|null $warehouse_id
 */
class Complectation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_complectation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['count', 'warehouse_id', 'provider_warehouse_id', 'supplier_warehouse_id', 'nomenclature_product_id', 'new_product_count', 'new_product_count'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Արժեք',
            'name' => 'Անվանում',
            'count' => 'Քանակ',
            'created_at' => 'Ստեղծման ամսաթիվ',
            'warehouse_id' => 'Պահեստ',
        ];
    }
}
