<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShippingProducts;

/**
 * ShippingProductSearch represents the model behind the search form of `app\modules\warehouse\models\ShippingProduct`.
 */
class ShippingProductSearch extends ShippingProducts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'shipping_id', 'product_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params , $shipping_id = null)
    {
        if ($shipping_id === null) {
            $query = ShippingProducts::find();
        } else {
            $query = ShippingProducts::find()->where(['shipping_id' => $shipping_id]);
        }
        // $query->leftJoin(['s_product', 's_product.mac_address = mac_address']);
//        if (Yii::$app->user->identity->username === 'ashotfast') {
//            $query = ShippingProduct::find();
//        } else {
//            $query = ShippingProduct::find();
//        }
        //$query = ShippingProduct::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        // grid filtering conditions
        $filter = [
            'id' => $this->id,
            'shipping_id' => $this->shipping_id,
            'product_id' => $this->product_id,
            's_shipping_products.mac_address' => $this->product->mac_address,
        ];
        if ($this->created_at) {
            $filter['created_at'] = date("Y-m-d H:i:s", strtotime($this->created_at));
        } 
        $query->andFilterWhere($filter);

        return $dataProvider;
    }
}
