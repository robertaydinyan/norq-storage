<?php

namespace app\models;

use Yii;
use app\models\User;
use app\modules\warehouse\models\Balance;
use app\models\Notifications;
use app\modules\fastnet\models\Deal;
use app\modules\crm\models\Contact;
use app\modules\reports\models\Cost;
use app\modules\crm\models\ContactAdress;
use app\modules\warehouse\models\ProductForRequest;


/**
 * This is the model class for table "s_shipping_request".
 *
 * @property int $id
 * @property int $count
 * @property string $created_at
 * @property int $nomenclature_product_id
 * @property int $shipping_id
 * @property int $shipping_type
 * @property int|null $supplier_id
 * @property int|null $is_phys
 * @property string|null $invoice
 * @property string|null $comment
 * @property int|null $request_id
 */

class ShippingRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_shipping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'created_at','shipping_type'], 'required'],
            [['created_at'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => 'Քանակ',
            'created_at' => 'Created At',
            'nomenclature_product_id' => 'Ապրանքի Նոմենկլատուրա',
            'shipping_id' => 'Shipping ID',
            'shipping_type' => 'Տեսակ',
            'request_id' => 'Գնման հայտ',
            'provider_warehouse_id' => 'Հանձնող պահեստ',
            'supplier_warehouse_id' => 'Ստացող պահեստ',
            'status' => 'Կարգավիճակ',
            'comment' => 'Մեկնաբանություն',
            'user_id' => 'Պատասխանատու'
        ];
    }

    public function getNProduct()
    {
        return $this->hasOne(NomenclatureProduct::class, ['id' => 'nomenclature_product_id']);
    }
    public function getShippingtype()
    {
        return $this->hasOne(ShippingType::class, ['id' => 'shipping_type']);
    }
    public function getStatus_()
    {
        return $this->hasOne(StatusList::class, ['id' => 'status']);
    }
    public function getProvider()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'provider_warehouse_id']);
    }
    public function getSupplier()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'supplier_warehouse_id']);
    }
    public function getSupplierp()
    {
        if($this->is_phys ==0){
           return $this->hasOne(SuppliersList::class, ['id' => 'supplier_id']);
        } else {
           $deal =  Deal::find()->where(['deal_number'=>$this->supplier_id])->one();
           $contact = Contact::find()->where(['id'=>$deal->crm_contact_id])->one();
           return $contact;
        }
    }
    public function getPartner()
    {
        return $this->hasOne(SuppliersList::class, ['id' => 'partner_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getProducts()
    {
        return $this->hasMany(ShippingProducts::class, ['shipping_id' => 'id']);
    }

    public function getTotalsum() {
        if($this->shipping_type !=5){
            $products = Yii::$app->db->createCommand("SELECT count,price FROM s_shipping_products WHERE shipping_id = $this->id")->queryAll();
            $sum = 0;
            if(!empty($products)){
                foreach ($products as $product => $prod_val){
                    $sum += $prod_val['price'] * $prod_val['count'];
                }
                return $sum;
            } else {
                return 0;
            }
        } else {
            $products = Yii::$app->db->createCommand("SELECT count,price FROM s_product_for_request WHERE shipping_id = $this->id")->queryAll();
            $sum = 0;
            if(!empty($products)){
                foreach ($products as $product => $prod_val){
                    $sum += $prod_val['price'] * $prod_val['count'];
                }
                return $sum;
            } else {
                return 0;
            } 
        }

    }
      public function getPartnerTotalAmount($id) {
        
            $products = Yii::$app->db->createCommand("SELECT s_shipping_products.count,s_shipping_products.price FROM s_shipping_products LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id WHERE s_shipping.supplier_id = $id")->queryAll();
            $sum = 0;
            $pays = Yii::$app->db->createCommand("SELECT SUM(price) as total FROM s_provider_payments WHERE provider_id = $id")->queryOne();
            if(!empty($products)){
                foreach ($products as $product => $prod_val){
                    $sum += $prod_val['price'] * $prod_val['count'];
                }
                return $sum-$pays['total'];
            } else {
                return 0;
            }

    }
    
    public function getTotalsumsale() {

        $products = Yii::$app->db->createCommand("SELECT count,price FROM s_shipping_products WHERE shipping_id = $this->id")->queryAll();
        $sum = 0;
        if(!empty($products)){
            foreach ($products as $product => $prod_val){
                $sum += $prod_val['price'] * $prod_val['count'];
            }
            return $sum;
        } else {
            return 0;
        }

    }

    public function addShippingProducts($model, $request){
                if($model->shipping_type != 2  && $model->shipping_type != 6 && $model->shipping_type != 5) {
                    if (isset($request['ShippingRequest']['nomenclature_product_id']) && !empty($request['ShippingRequest']['nomenclature_product_id'])) {
                        foreach ($request['ShippingRequest']['nomenclature_product_id'] as $key => $nProductId) {
                            if ($request['ShippingRequest']['count'][$key]) {
                                $Origin_product = Product::findOne($nProductId);
                                if($Origin_product->nProduct->individual == 'false'){
                                    $products = Product::find()->where(['nomenclature_product_id'=>$Origin_product->nomenclature_product_id,'warehouse_id'=>$Origin_product->warehouse_id,'status'=>1])
                                        ->andWhere(['<=','created_at',$model->created_at])->orderBy(['created_at'=>SORT_ASC])->all();
                                    $total = intval($request['ShippingRequest']['count'][$key]);
                                    foreach ($products as $produst => $prodval){

                                            if($prodval->count >= $total){
                                                $prodval->count = $prodval->count - $total;
                                                $prodval->save(false);
                                                $ShippingProduct = new ShippingProducts();
                                                $ShippingProduct->product_id = $prodval->id;
                                                $ShippingProduct->created_at = $model->created_at;
                                                $ShippingProduct->count = $total;
                                                $ShippingProduct->shipping_type = $model->shipping_type;
                                                if($model->shipping_type == 9) {
                                                    $ShippingProduct->price = $request['ShippingRequest']['price'][$key];
                                                } else {
                                                    $ShippingProduct->price = $prodval->price;
                                                }
                                                $ShippingProduct->shipping_id = $model->id;
                                                $ShippingProduct->save(false);
                                                break;
                                            } else {
                                                $total = $total - $prodval->count;
                                                $ShippingProduct = new ShippingProducts();
                                                $ShippingProduct->product_id = $prodval->id;
                                                $ShippingProduct->created_at = $model->created_at;
                                                $ShippingProduct->count = $prodval->count;
                                                $ShippingProduct->shipping_type = $model->shipping_type;
                                                if($model->shipping_type == 9) {
                                                    $ShippingProduct->price = $request['ShippingRequest']['price'][$key];
                                                } else {
                                                    $ShippingProduct->price = $prodval->price;
                                                }
                                                $ShippingProduct->shipping_id = $model->id;
                                                $ShippingProduct->save(false);

                                                $prodval->count = 0;
                                                $prodval->status = 0;
                                                $prodval->save(false);
                                            }
                                     }
                                } else {
                                    $ShippingProduct = new ShippingProducts();
                                    $ShippingProduct->product_id = $Origin_product->id;
                                    $ShippingProduct->created_at = $model->created_at;
                                    $ShippingProduct->count = 1;
                                    if($model->shipping_type == 9) {
                                        $ShippingProduct->price = $request['ShippingRequest']['price'][$key];
                                    } else {
                                        $ShippingProduct->price = $Origin_product->price;
                                    }
                                    $ShippingProduct->shipping_id = $model->id;
                                    $ShippingProduct->shipping_type = $model->shipping_type;
                                    $ShippingProduct->save(false);
                                    if($Origin_product) {
                                        $Origin_product->count = 0;
                                        $Origin_product->status = 0;
                                        $Origin_product->save(false);
                                    }

                                }
                            }
                        }
                    }
                } else if($model->shipping_type != 5) {
                    if ($request['Product']) {
                        for ($i = 0; $i < count($request['Product']['nomenclature_product_id']); $i++){
                            if(intval($request['Product']['notice_if_move'][$i]) && !empty($request['Product']['nomenclature_product_id']) && $request['Product']['nomenclature_product_id'][0]){
                                for ($j = 0; $j < count($request['Product']['mac_address'][$i]);$j++){
                                    if(empty($request['Product']['mac_address'][$i][$j]) || Product::find()->where(['mac_address'=>$request['Product']['mac_address'][$i][$j]])->one()){
                                        continue;
                                    }
                                    $product = new Product();
                                    $product->price = $request['Product']['price'][$i];
                                    $product->supplier_id = $model->supplier_id;
                                    $product->invoice = $model->invoice;
                                    $product->count = 1;
                                    $product->status = 0;
                                    $product->created_at = $model->created_at;
                                    $product->shipping_id = $model->id;
                                    $product->warehouse_id = $model->supplier_warehouse_id;
                                    $product->nomenclature_product_id = $request['Product']['nomenclature_product_id'][$i];
                                    $product->comment = $request['Product']['comment'][$i];
                                    $product->mac_address = $request['Product']['mac_address'][$i][$j];
                                    $product->save(false);

                                    $ShippingProduct = new ShippingProducts();
                                    $ShippingProduct->product_id = $product->id;
                                    $ShippingProduct->created_at = $model->created_at;
                                    $ShippingProduct->shipping_type = $model->shipping_type;
                                    $ShippingProduct->count = $request['Product']['count'][$i];
                                    $ShippingProduct->price = $request['Product']['price'][$i];
                                    $ShippingProduct->shipping_id = $model->id;
                                    $ShippingProduct->save(false);
                                }
                            } else if($request['Product']['nomenclature_product_id'][0]) {
                                $product = new Product();
                                $product->price = $request['Product']['price'][$i];
                                $product->supplier_id = $model->supplier_id;
                                $product->invoice = $model->invoice;
                                $product->status = 0;
                                $product->created_at = $model->created_at;
                                $product->shipping_id = $model->id;

                                $product->count = $request['Product']['count'][$i];
                                $product->comment = $request['Product']['comment'][$i];
                                $product->warehouse_id = $model->supplier_warehouse_id;
                                $product->nomenclature_product_id = $request['Product']['nomenclature_product_id'][$i];
                                $product->save(false);

                                $ShippingProduct = new ShippingProducts();
                                $ShippingProduct->product_id = $product->id;
                                $ShippingProduct->created_at = $model->created_at;
                                $ShippingProduct->count = $request['Product']['count'][$i];
                                $ShippingProduct->price =  $request['Product']['price'][$i];
                                $ShippingProduct->shipping_type = $model->shipping_type;
                                $ShippingProduct->shipping_id = $model->id;
                                $ShippingProduct->save(false);
                            }
                        }
                    }
                } else {
                    for ($i = 0; $i < count($request['Product']['nomenclature_product_id']); $i++){
                        $product = new ProductForRequest();
                        $product->price = $request['Product']['price'][$i];
                        $product->supplier_id = $model->supplier_id;
                        $product->invoice = $model->invoice;
                        $product->count = $request['Product']['count'][$i];
                        $product->comment = $request['Product']['comment'][$i];
                        $product->status = 0;
                        $product->created_at = $model->created_at;
                        $product->shipping_id = $model->id;
                        $product->warehouse_id = $model->supplier_warehouse_id;
                        $product->nomenclature_product_id = $request['Product']['nomenclature_product_id'][$i];
                        $product->save(false);
                    }
                }
            }

    public function addShippingProductsDeal($model, $request){
                
                $price = 0;
                if($model->shipping_type != 2  && $model->shipping_type != 6) {
                    if (isset($request['ShippingRequest']['nomenclature_product_id']) && !empty($request['ShippingRequest']['nomenclature_product_id'])) {
                        foreach ($request['ShippingRequest']['nomenclature_product_id'] as $key => $nProductId) {
                          
                            $Origin_product = Product::findOne($nProductId);
                            if($Origin_product->nProduct->individual == 'false'){
                                $products = Product::find()->where(['nomenclature_product_id'=>$Origin_product->nomenclature_product_id,'warehouse_id'=>$Origin_product->warehouse_id,'status'=>1])
                                    ->andWhere(['<=','created_at',$model->created_at])->orderBy(['created_at'=>SORT_ASC])->all();

                                $total = intval($request['ShippingRequest']['count'][$key]);
                                foreach ($products as $produst => $prodval){
                                        if($prodval->count >= $total){
                                            $prodval->count = $prodval->count - $total;
                                            $prodval->save(false);
                                            $ShippingProduct = new ShippingProducts();
                                            $ShippingProduct->product_id = $prodval->id;
                                            $ShippingProduct->created_at = $model->created_at;
                                            $ShippingProduct->count = $total;
                                            $ShippingProduct->shipping_type = $model->shipping_type;
                                            if($model->shipping_type == 9) {
                                                $ShippingProduct->price = $request['ShippingRequest']['price'][$key];
                                            } else {
                                                $ShippingProduct->price = $prodval->price;
                                            }
                                            $price += $ShippingProduct->price*$total;
                                            $ShippingProduct->shipping_id = $model->id;
                                            $ShippingProduct->save(false);
                                            
                                        
                                            break;
                                        } else {
                                            $total = $total - $prodval->count;
                                            $ShippingProduct = new ShippingProducts();
                                            $ShippingProduct->product_id = $prodval->id;
                                            $ShippingProduct->created_at = $model->created_at;
                                            $ShippingProduct->count = $prodval->count;
                                            $ShippingProduct->shipping_type = $model->shipping_type;
                                            if($model->shipping_type == 9) {
                                                $ShippingProduct->price = $request['ShippingRequest']['price'][$key];
                                            } else {
                                                $ShippingProduct->price = $prodval->price;
                                            }

                                            $price += $ShippingProduct->price* $prodval->count;

                                            $ShippingProduct->shipping_id = $model->id;
                                            $ShippingProduct->save(false);
                                            
                                        
                                            $prodval->count = 0;
                                            $prodval->status = 0;
                                            $prodval->save(false);
                                        }

                                 }
                            } else {
                                $ShippingProduct = new ShippingProducts();
                                $ShippingProduct->product_id = $Origin_product->id;
                                $ShippingProduct->created_at = $model->created_at;
                                $ShippingProduct->count = 1;
                                if($model->shipping_type == 9) {
                                    $ShippingProduct->price = $request['ShippingRequest']['price'][$key];
                                } else {
                                    $ShippingProduct->price = $Origin_product->price;
                                }
                                $price += $ShippingProduct->price;
                                $ShippingProduct->shipping_id = $model->id;
                                $ShippingProduct->shipping_type = $model->shipping_type;
                                $ShippingProduct->save(false);
                                if($Origin_product) {
                                    $Origin_product->count = 0;
                                    $Origin_product->status = 0;
                                    $Origin_product->save(false);
                                }

                                 $log = new ProductShippingLog();
                                 $log->from_ = $model->provider->name;
                                 $log->to_ = $model->supplier->name;
                                 $log->mac_address = $Origin_product->mac_address;
                                 $log->shipping_type = $model->shipping_type;
                                 $log->request_id = $model->id;
                                 $log->date_create = $model->created_at;
                                 $log->save(false);

                            }
                            
                        }

                    }

                    if($model->shipping_type == 7){
                        $products = ShippingProducts::find()->where(['shipping_id'=>$model->id])->all();
                        foreach ($products as $product => $prod_val){
                            $newProduct = Product::findOne($prod_val->product_id);
                            $newProduct->id = null;
                            $newProduct->status = 1;
                            $newProduct->isNewRecord = true;
                            $newProduct->created_at = $model->created_at;
                            $newProduct->warehouse_id = $model->supplier_warehouse_id;
                            $newProduct->count = $prod_val->count;
                            $newProduct->price = 0;
                            $newProduct->save(false);
                        }

                        $addr = ContactAdress::find()->where(['id'=>$model->supplier->contact_address_id])->one();
                        
                        $costObj = new Cost();
                        $costObj->cost_date = $model->created_at;
                        $costObj->creation_date = $model->created_at;
                        $costObj->cost_type = 7;
                        $costObj->cost_sum = intval($price);
                        $costObj->is_internet = 0;
                        $costObj->is_tv = 0;
                        $costObj->is_ip = 0;
                        $costObj->place = $addr->country_id.'/'.$addr->region_id.'/'.$addr->city_id.'/'.$addr->community_id;
                        $costObj->place_text = '';
                        $costObj->insert();  

                                          
                    }
                    if($model->shipping_type == 9){
                        $price_b = 0;
                        $products = ShippingProducts::find()->where(['shipping_id'=>$model->id])->all();
                        foreach ($products as $product => $prod_val){
                           $prod =  Product::findOne($prod_val->product_id);
                           $price_b += ($product->count * $product->price);
                           $prod->count = 0;
                           $product->status = 0;
                           $prod->save(false);
                        }
                       

                    }
                    if($model->shipping_type == 10){
                        $products = ShippingProducts::find()->where(['shipping_id'=>$model->id])->all();
                        foreach ($products as $product => $prod_val){
                           $prod =  Product::findOne($prod_val->product_id);
                           $prod->count = 0;
                           $product->status = 0;
                           $prod->save(false);
                        }
                    }
                     Notifications::setNotification($model->provider->responsible_id,"Կատարվել է ".$model->shippingtype->name." <b>".$model->provider->name."</b> -  <b>".$model->supplier->name."</b> ",'/shipping-request/view?id='.$model->id);
                    Notifications::setNotification($model->supplier->responsible_id,"Կատարվել է ".$model->shippingtype->name." <b>".$model->provider->name."</b> - <b>".$model->supplier->name."</b> ",'/shipping-request/view?id='.$model->id);
                    if(($model->supplier->responsible_id != $model->user_id) && ($model->provider->responsible_id !=$model->user_id)){
                        Notifications::setNotification($model->user_id,"Կատարվել է ".$model->shippingtype->name." <b>".$model->provider->name."</b> - <b>".$model->supplier->name."</b> ",'/shipping-request/view?id='.$model->id);
                    }

                } 

                return  $price;

            }
    }


