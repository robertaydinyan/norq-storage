<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_warehouse_types".
 *
 * @property int $id
 * @property string $name
 */
class WarehouseTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_warehouse_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Անվանում',
        ];
    }
    public function getCount() {
        return Warehouse::find()->where(['type'=>$this->id])->count();
    }
}
