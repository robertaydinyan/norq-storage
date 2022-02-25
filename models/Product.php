<?php

namespace app\models;


use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "s_product".
 *
 * @property int $id
 * @property float|null $price
 * @property float|null $retail_price
 * @property int|null $supplier_id
 * @property string|null $mac_address
 * @property string|null $comment
 * @property string|null $used
 * @property string $created_at
 * @property int $warehouse_id
 * @property int $shipping_id
 * @property int $nomenclature_product_id
 * @property int $status
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $images;
    public static $groups = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'retail_price','shipping_id', 'min_qty', 'notice_if_move','status'], 'number'],
            [['created_at', 'warehouse_id', 'nomenclature_product_id'], 'required'],
            [['warehouse_id', 'nomenclature_product_id'], 'integer'],
            [['supplier_id', 'mac_address','invoice' , 'comment', 'used', 'created_at'], 'string', 'max' => 255],
            [['images'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'images' => 'Արտադրանքի նկարները',
            'price' => 'Գին',
            'retail_price' => 'Մանրածախ գին',
            'supplier_id' => 'Մատակարար',
            'mac_address' => 'Mac հասցե',
            'invoice' => 'Invoice',
            'comment' => 'Մեկնաբանություն',
            'count' => 'Քանակ',
            'created_at' => 'Ստեղծվել է /ժամը/',
            'warehouse_id' => 'Պահեստ',
            'status' => 'Պահեստ',
            'nomenclature_product_id' => 'Ապրանք',
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->images as $image) {
                $image->saveAs('uploads/' . $image->baseName . '.' . $image->extension);
            }
            return true;
        } else {
            return false;
        }
    }
    public function getWareHouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse_id']);
    }
    public function MoveData($data, $nomiclature, $warehouse)
    {
        $start = date('Y-m-d',strtotime($data['from_created_at']));
        $end = date('Y-m-d',strtotime($data['to_created_at']));
        $warehouse_id = intval($data['supplier_warehouse_id']);

        if(!$warehouse_id){
             $closing = intval(Yii::$app->db->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(2,6,7)  AND `s_shipping_products`.`created_at` <= '$end'")->queryOne()['pcount']);
             $sell_in = intval(Yii::$app->db->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(2,6,7) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryOne()['pcount']);
        
            $sell_out = intval(Yii::$app->db->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id 
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE  s_product.nomenclature_product_id = $nomiclature AND s_shipping.provider_warehouse_id = $warehouse  AND s_shipping.shipping_type IN(8,9,7,10) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryOne()['pcount']);

        } else {
               $closing = intval(Yii::$app->db->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id 
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE  s_product.nomenclature_product_id = $nomiclature AND s_shipping.provider_warehouse_id = $warehouse  AND s_shipping.supplier_warehouse_id = $warehouse_id AND (s_product.status = 1 OR s_product.count>0)  AND   s_shipping.shipping_type IN(8,9,7,10) AND `s_shipping_products`.`created_at` <= '$end'")->queryOne()['pcount']);
            $sell_in = intval(Yii::$app->db->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id 
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse AND s_shipping.supplier_warehouse_id = $warehouse_id   AND s_shipping.shipping_type IN(2,6,7) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryOne()['pcount']);
            $sell_out = intval(Yii::$app->db->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id 
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE  s_product.nomenclature_product_id = $nomiclature AND s_shipping.provider_warehouse_id = $warehouse  AND s_shipping.supplier_warehouse_id = $warehouse_id  AND  s_shipping.shipping_type IN(8,9,7,10) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryOne()['pcount']);
        }
        return ['closing'=>$closing,'sell_in'=>$sell_in,'sell_out'=>$sell_out];
    }

    public function findByData($data)
    {
        $sql = '';
        if($data["from_created_at"] && $data["to_created_at"]){
            $sql = 'WHERE `s_product`.`created_at` >= "'.date('Y-m-d',strtotime($data["from_created_at"])).'" AND `s_product`.`created_at` <= "'.date('Y-m-d',strtotime($data["to_created_at"])).'"';
        }
        if($data["virtual_type"]){
            if(empty($sql)) {
                $sql = 'WHERE `s_warehouse`.`group_id` =' . intval($data["virtual_type"]);
            } else {
                $sql .= ' AND `s_warehouse`.`group_id` =' . intval($data["virtual_type"]);
            }
        }
        if($data["warehouse_type"]){
            if(empty($sql)) {
                $sql = 'WHERE `s_warehouse`.`type` =' . intval($data["warehouse_type"]);
            } else {
                $sql .= ' AND `s_warehouse`.`type` =' . intval($data["warehouse_type"]);
            }
        }
        if($data["region_id"]){
            if(empty($sql)) {
                $sql = 'WHERE `contact_adress`.`region_id` =' . intval($data["region_id"]);
            } else {
                $sql .= ' AND `contact_adress`.`region_id` =' . intval($data["region_id"]);
            }
        }
        if($data["community_id"]){
            if(empty($sql)) {
                $sql = 'WHERE `contact_adress`.`community_id` =' . intval($data["community_id"]);
            } else {
                $sql .= ' AND `contact_adress`.`community_id` =' . intval($data["community_id"]);
            }
        }
        if($data["supplier_warehouse_id"]){
            if(empty($sql)) {
                $sql = 'WHERE `s_product`.`warehouse_id` =' . $data["supplier_warehouse_id"];
            } else {
                $sql .= ' AND `s_product`.`warehouse_id` =' . $data["supplier_warehouse_id"];
            }
        }

        if($data["serias"]){
            $serias = substr($data["serias"],0,-1);
            if(empty($sql)) {
                $sql = 'WHERE `s_product`.`mac_address` IN('.$serias.')';
            } else {
                $sql .= ' AND `s_product`.`mac_address` IN('.$serias.')';
            }
        }
        if(!$data["serias"] && $data['nomiclature_id']){
            $serias = substr($data["serias"],0,-1);

            if(empty($sql)) {
                $sql = 'WHERE `s_product`.`nomenclature_product_id` = '.$data['nomiclature_id'];
            } else {
                $sql .= ' AND `s_product`.`nomenclature_product_id` = '.$data['nomiclature_id'];
            }
        }
        if(!$data["serias"] && !$data['nomiclature_id'] && $data['group']){
           
            $grups__ = Product::getChilds($data['group']);
            $group_string = implode(',', $grups__);
            if(empty($sql)) {
                $sql = 'WHERE `s_nomenclature_product`.`group_id` IN( '.$group_string.') ';
            } else {
                $sql .= ' AND `s_nomenclature_product`.`group_id` IN( '.$group_string.') ';
            }
        }

        if(empty($sql)){
            $sql .=' WHERE s_product.count > 0';
        } else {
            $sql .=' AND s_product.count > 0';
        }
        if(!isset($data['show-ware'])) {
            $group_by = 'GROUP BY s_product.id';
        } else {
            $group_by = 'GROUP BY s_product.id,s_product.warehouse_id';
        }
 
        if(!isset($data['show-series'])){
            if(!isset($data['show-ware'])) {
                $group_by = 'GROUP BY s_product.nomenclature_product_id';
            } else {
                $group_by = 'GROUP BY s_product.nomenclature_product_id,s_product.warehouse_id ';
            }
        }
  
        return Yii::$app->db->createCommand("SELECT SUM(s_product.count) as pcount,SUM(s_product.price * s_product.count) as pprice,AVG(s_product.price) as avgprice,s_warehouse.name as wname,s_nomenclature_product.*,s_qty_type.type as qty_type,s_product.*,s_product.mac_address as mac FROM s_product            
                                                     LEFT JOIN s_nomenclature_product ON s_nomenclature_product.id = s_product.nomenclature_product_id
                                                     LEFT JOIN s_qty_type ON s_nomenclature_product.qty_type_id = s_qty_type.id 
                                                     LEFT JOIN s_warehouse ON s_warehouse.id = s_product.warehouse_id 
                                                     LEFT JOIN contact_adress ON s_warehouse.contact_address_id = contact_adress.id 
                                                   $sql  $group_by")->queryAll();
    }
    public function getNProduct()
    {
        return $this->hasOne(NomenclatureProduct::class, ['id' => 'nomenclature_product_id']);
    }

    public function getChilds($group_id){
        if($group_id){
           $groups_ = GroupProduct::find()->where(['group_id'=>$group_id])->all();
            array_push(self::$groups, $group_id);
           if(!empty($groups_)){
              foreach($groups_ as $group => $group_val){
                  array_push(self::$groups, $group_val['id']);
                  Product::getChilds($group_val['id']);
              }
           }
       } 
       return self::$groups;
    }
    public function findForNotice()
    {
        return Yii::$app->db->createCommand("SELECT SUM(s_product.count) as pcount,s_nomenclature_product.min_qty as minqty,s_nomenclature_product.*,s_product.*,s_qty_type.type as qty_type
                                             FROM s_product            
                                              LEFT JOIN s_nomenclature_product ON s_nomenclature_product.id = s_product.nomenclature_product_id
                                               LEFT JOIN s_qty_type ON s_nomenclature_product.qty_type_id = s_qty_type.id 
                                               WHERE s_product.warehouse_id = 20 AND s_nomenclature_product.min_qty>0 AND s_product.count > 0 GROUP BY s_product.nomenclature_product_id 
                                              ")->queryAll();
    }
}
