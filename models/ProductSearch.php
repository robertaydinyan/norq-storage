<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\modules\warehouse\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'warehouse_id', 'nomenclature_product_id'], 'integer'],
            [['price', 'retail_price'], 'number'],
            [['supplier_name', 'mac_address', 'comment', 'used', 'created_at'], 'safe'],
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

    public function childTree(array $tableTreeGroups) {

        $result = [];


        foreach ($tableTreeGroups as $treeGroup) {
            if (!isset($treeGroup['children'])){
                $result[] = $treeGroup['id'];
            } else {
                $result = array_merge($result, $this->childTree($treeGroup['children']));
            }
        }
        return $result;
    }


    public function buildTree(array $elements, $parentId = null) {

        $branch = array();
        foreach ($elements as $element) {

            if ($element['group_id'] == $parentId) {

                $children = $this->buildTree($elements, $element['id']);

                if ($children) {

                    $element['children'] =  $children;

                }

                $branch[] = $element;

            }

        }
        return $branch;

    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
    
        $whProducts = Yii::$app->db->createCommand("SELECT s_warehouse.name as wname,s_nomenclature_product.img,s_nomenclature_product.id as nid,s_qty_type.type as qtype,s_nomenclature_product.individual,s_nomenclature_product.name as nomeclature_name,s_warehouse.id,s_warehouse.contact_address_id,s_warehouse.type,nomenclature_product_id, sum(count) AS `count_n_product` FROM `s_product` LEFT JOIN `s_nomenclature_product` ON `s_product`.`nomenclature_product_id` = `s_nomenclature_product`.`id` LEFT JOIN `s_qty_type` ON `s_nomenclature_product`.`qty_type_id` = `s_qty_type`.`id` LEFT JOIN `s_warehouse` ON `s_product`.`warehouse_id` = `s_warehouse`.`id` WHERE `status`=1 AND s_product.count>0 GROUP BY `nomenclature_product_id`, `warehouse_id` ORDER BY `count_n_product`")->queryAll();

        return ['result' => $whProducts, 'params' => $params];
    }
    
}
