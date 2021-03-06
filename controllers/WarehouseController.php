<?php

namespace app\controllers;

use app\models\User;
use app\models\Regions;
use app\models\Streets;
use app\models\NomenclatureProduct;
use app\models\Product;
use app\models\ProductImagesPath;
use app\models\SuppliersList;
use app\models\WarehouseGroups;
use app\models\WarehouseTypes;
use Yii;
use app\models\Warehouse;
use app\models\WarehouseSearch;
use app\modules\fastnet\models\Deal;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Carbon\Carbon;
use yii\helpers\ArrayHelper;
use app\modules\crm\models\Company;
use app\models\Contact;
use app\models\ContactAdress;
use yii\web\UploadedFile;
use app\models\Notifications;
use app\models\BaseQuery;
use app\models\Countries;

/**
 * WarehouseController implements the CRUD actions for Warehouse model.`
 */
class WarehouseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Warehouse models.
     * @return mixed
     */
    public function actionIndex()
    {
        // if(!\Yii::$app->user->can('admin')){
        //     $warehouse = Warehouse::find()->where(['responsible_id'=>Yii::$app->user->getId()])->one();
        //     $this->redirect('/warehouse/view?id='.$warehouse->id);
        // }

        $warehouse_types = WarehouseTypes::find()->all();
        return $this->render('index', [
            'warehouse_types' =>$warehouse_types,
        ]);
    }
    public function actionShowByType()
    {
        $searchModel = new WarehouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $warehouse_types = WarehouseTypes::find()->all();

        return $this->render('show-by-type', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'warehouse_types' =>$warehouse_types,

        ]);
    }

    public function actionGetProductInfo(){
        $get = Yii::$app->request->get();
        if(intval($get['id'])) {
            return $this->renderAjax('products-info', [
                'products' => Product::find()->where(['nomenclature_product_id'=>intval($get['id']),'warehouse_id'=>intval($get['wid']),'status'=>1])->all(),
            ]);
        } else {
            return [];
        }
    }
    public function actionByType()
    {
        $type = Yii::$app->request->get()['type'];
        $region = Yii::$app->request->get()['region'];
        if(intval($type)) {
            if(intval($type) != 2){
                if(!$region) {
                    $regions = Regions::find()->all();
                    return $this->render('by-type', ['regions' => $regions, 'type' => $type]);
                } else {
                    $communities = Warehouse::getByRegionCommunities($region);
                    return $this->render('by-type-and-region', ['communities' => $communities, 'type' => $type,'region'=>$region]);
                }
            } else {
                $subs = WarehouseGroups::find()->all();
                return $this->render('by-subs',['subs'=>$subs]);
            }

        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Displays a single Warehouse model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $id = intval($_GET['id']);
        $whProducts = Product::find()
            ->where(['warehouse_id'=>$id,'status'=>1])
            ->joinWith(['nProduct', 'nProduct.qtyType'])
            ->select([
                ' nomenclature_product_id, sum(count) AS count_n_product',
            ])
            ->groupBy('nomenclature_product_id', 'count')
            ->orderBy('count_n_product', 'desc')
            ->asArray()->all();

        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()->all(), 'id', 'name');
        $suppliers = ArrayHelper::map(SuppliersList::find()->asArray()->all(), 'id', 'name');
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])->where(['id' => $id])->asArray()->all(), 'id', 'name');

      
        if ($this->findModel($id)->contact_address_id !== null) {
            $model = $this->findModel($id);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'whProducts' => $whProducts,
            'suppliers' => $suppliers,
            'nProducts' =>$nProducts,
            'physicalWarehouse' =>$physicalWarehouse,

        ]);
    }

    /**
     * Creates a new Warehouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Warehouse();
        $address = new ContactAdress();
        
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(), 'name', 'last_name' , 'id');
        $warehouse_types = ArrayHelper::map(WarehouseTypes::find()->asArray()->all(), 'id' ,'name');
        $warehouse_groups = ArrayHelper::map(WarehouseGroups::find()->asArray()->all(), 'id' ,'name');
        $countries = BaseQuery::getCountriesList();
        $dataUsers = [];
        foreach ($uersData as $key => $value) {
           $dataUsers[$key] = $value[array_key_first($value)] . ' ' . array_key_first($value);
        }

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $C_C_address = array();//$post['ContactAdress'];
          
            if (!empty($C_C_address['country_id']['0'])) {
                foreach ($C_C_address['country_id'] as $k => $add) {
                    $street = Streets::findOne(['id' => intval($C_C_address['street'][$k])]);
                    $streetId = null;
                    if (empty($street) || !$C_C_address['street'][$k]) {
                        $new_street = new Streets();
                        $new_street->name = $C_C_address['street'][$k];
                        $new_street->city_id = $C_C_address['city_id'][$k];
                        $new_street->community_id = $C_C_address['community_id'][$k];
                        if ($new_street->save()) {
                            $streetId = $new_street->id;
                        }
                    } else {
                        $streetId = $street->id;
                    }
                    // ToDo: commented
                    // $addressForSave = new ContactAdress();
                    // if (isset($C_C_address['community_id'][$k])) {
                    //     $addressForSave->community_id = $C_C_address['community_id'][$k];
                    // } else {
                    //     $addressForSave->community_id = 0;
                    // }
                    // $addressForSave->country_id = $C_C_address['country_id'][$k];
                    // $addressForSave->region_id = $C_C_address['region_id'][$k];
                    // $addressForSave->city_id = $C_C_address['city_id'][$k];
                    // $addressForSave->street = $streetId;
                    // $addressForSave->house = $C_C_address['house'][$k];
                    // $addressForSave->housing = $C_C_address['housing'][$k];
                    // $addressForSave->apartment = $C_C_address['apartment'][$k];
                    
                    // if ($addressForSave->save(false)) {
                    //     $model->created_at  = Carbon::now()->toDateTimeString();
                    //     $model->contact_address_id = $addressForSave->id;
                    //     $model->save(false);
                    // }

                }
            } else {
                $model->created_at  = Carbon::now()->toDateTimeString();
                $model->save();
            }

            Notifications::setNotification(1,"?????????????? <b>".$model->name."</b> ???????????????????????? ???????????????? ??",'/warehouse/view?id='.$model->id);
            Notifications::setNotification($model->responsible_id,"?????????????? <b>".$model->name."</b> ???????????????????????? ???????????????? ??",'/warehouse/view?id='.$model->id);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'dataUsers'=>$dataUsers,
            'address' => $address,
            'warehouse_types' => $warehouse_types,
            'warehouse_groups' =>$warehouse_groups,
            'countries' => $countries
        ]);
    }

    /**
     * Updates an existing Warehouse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // $address = new ContactAdress();
        $model->updated_at  = Carbon::now()->toDateTimeString();
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(), 'name', 'last_name' , 'id');
        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value)] . ' ' . array_key_first($value);
        }
        $users = User::find()->select([
            'name',
            'last_name'
        ])->where(['status' => User::STATUS_ACTIVE])
            ->asArray()->all();
        $responsiblePersons = [];
        foreach ($users as $value) {
            $responsiblePersons[$value['name'] . ' ' .$value['last_name']] = $value['name'] . ' ' .$value['last_name'];
        }
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            // ToDo: commented
            // $C_C_address = $post['ContactAdress'];
            // if (!empty($C_C_address['country_id'])) {

            //     foreach ($C_C_address['country_id'] as $k => $add) {
            //         $street = Streets::findOne(['id' => intval($C_C_address['street'][$k])]);
            //         $streetId = null;

            //         if (empty($street) || !$C_C_address['street'][$k]) {
            //             $new_street = new Streets();
            //             $new_street->name = $C_C_address['street'][$k];
            //             $new_street->city_id = $C_C_address['city_id'][$k];
            //             $new_street->community_id = $C_C_address['community_id'][$k];

            //             if ($new_street->save()) {
            //                 $streetId = $new_street->id;
            //             }
            //         } else {
            //             $streetId = $street->id;
            //         }

            //         $addressForSave = new ContactAdress();

            //         if (isset($C_C_address['community_id'][$k])) {
            //             $addressForSave->community_id = $C_C_address['community_id'][$k];
            //         } else {
            //             $addressForSave->community_id = 0;
            //         }
            //         $addressForSave->country_id = $C_C_address['country_id'][$k];
            //         $addressForSave->region_id = $C_C_address['region_id'][$k];
            //         $addressForSave->city_id = $C_C_address['city_id'][$k];
            //         $addressForSave->street = $streetId;
            //         $addressForSave->house = $C_C_address['house'][$k];
            //         $addressForSave->housing = $C_C_address['housing'][$k];
            //         $addressForSave->apartment = $C_C_address['apartment'][$k];

            //         if ($addressForSave->save()) {
            //             $model->contact_address_id = $addressForSave->id;
            //             $model->save();
            //         }

            //     }
            // }
            Notifications::setNotification(1,"?????????????? <b>".$model->name."</b> ???????????????????????? ???????????????? ??",'/warehouse/view?id='.$model->id);
            Notifications::setNotification($model->responsible_id,"?????????????? <b>".$model->name."</b> ???????????????????????? ???????????????? ??",'/warehouse/view?id='.$model->id);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dataUsers'=>$dataUsers,
            'responsiblePersons' => $responsiblePersons,
            'address' => $address,
        ]);
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->username === 'ashotfast') {
            $this->findModel($id)->delete();
        }
        $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Warehouse::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionDeal()
    {
        $dataWarehouses = ArrayHelper::map(Warehouse::find()->asArray()->all(), 'id', 'name');
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(), 'name', 'last_name' , 'id');

        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value)] . ' ' . array_key_first($value);
        }

        return $this->render('deal',[
            'dataWarehouses' => $dataWarehouses,
            'dataUsers'=>$dataUsers,
        ]);
    }
    public function actionGetCommunity(){
        $id = intval($_GET['region_id']);
        echo '<option value="">??????????????</option>';
        if($id){
            $communities = Warehouse::getByRegionCommunities($id);
            if($communities){

                foreach ($communities as $community => $com_val){
                    echo '<option value="'.$com_val['id'].'">'.$com_val['name'].'</option>';
                }
            }
        }
    }
    public function actionGetWarehouses(){
        $query = Warehouse::find();
        if(isset($_GET['type'])){
            $query->andFilterWhere([
                's_warehouse.type' => intval($_GET['type']),
            ]);
        }
        if(isset($_GET['community']) && intval($_GET['community'])){
            $query->joinWith(['contactAdress']);
            $query->andFilterWhere([
                'contact_adress.community_id' => intval($_GET['community']),
            ]);
        }
        echo '<option value="">????????????</option>';
        $dataProvider = $query->all();
            if($dataProvider){
                foreach ($dataProvider as $warehouse => $ware_val){
                    echo '<option value="'.$ware_val->id.'">'.$ware_val->name.'</option>';
                }
            }
    }
    public function actionGetWarehousesByType(){
        $query = Warehouse::find();
        if(isset($_GET['virtual_type'])){
            $query->andFilterWhere([
                's_warehouse.group_id' => intval($_GET['virtual_type']),
            ]);
        }
        echo '<option value="">????????????</option>';
        $dataProvider = $query->all();
            if($dataProvider){
                foreach ($dataProvider as $warehouse => $ware_val){
                    echo '<option value="'.$ware_val->id.'">'.$ware_val->name.'</option>';
                }
            }
    }

      public function actionGetDeals()
    {
        $q = $_GET['q'];
        $html = '<div style="max-height:250px;overflow:auto;"><br>';
        $deals = Deal::find()->where(['like', 'deal_number', $q . '%', false])->andWhere(['!=','crm_contact_id',''])->all();
        if(!empty($deals)){
            foreach($deals as $deal => $deal_val){
                $contact = Contact::find()->where(['id'=>$deal_val->crm_contact_id])->one();
                $html.='<div><div class="c-checkbox">
                    <input type="radio" value="'.$deal_val->deal_number.'" id="'.$deal_val->deal_number.'" class="form-control cn" name="ShippingRequest[supplier_id_phys]">
                    <label class="has-star" for="'.$deal_val->deal_number.'">'.$deal_val->deal_number.' ( '.$contact->name.' '.$contact->surname.')</label>
                    <div class="help-block invalid-feedback"></div>
                </div></div>';

            }
        }
        $html.='<script>
                    $(".cn").on("click",function(){
                        if($(this).is(":checked")){
                          $(".cn").not($(this)).removeAttr("checked");
                        }
                    })
               </script></div>';
        return $html;
    }
}