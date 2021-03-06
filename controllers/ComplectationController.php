<?php

namespace app\controllers;

use app\models\ComplectationProducts;
use app\models\NomenclatureProduct;
use app\models\Product;
use app\models\ShippingProducts;
use app\models\Warehouse;
use Yii;
use app\models\Complectation;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\User;
use app\models\Notifications;

/**
 * ComplectationController implements the CRUD actions for Complectation model.
 */
class ComplectationController extends Controller
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
     * Lists all Complectation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Complectation::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Complectation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $id = intval($_GET['id']);
        $whProducts = ComplectationProducts::find()->where(['complectation_id'=>$id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'whProducts' => $whProducts,
        ]);
    }

    /**
     * Creates a new Complectation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Complectation();
        $model_products = new ComplectationProducts();

        $dataWarehouses = ArrayHelper::map(Warehouse::find()->asArray()->all(), 'id', 'name');
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $total_price = 0;
            if (isset($post['ComplectationProducts']['product_id']) && !empty($post['ComplectationProducts']['product_id'])) {
                foreach ($post['ComplectationProducts']['product_id'] as $key => $nProductId) {
                     if ($post['ComplectationProducts']['n_product_count'][$key]) {
                        $Origin_product = Product::findOne($nProductId);
                        $total_price += (intval($post['ComplectationProducts']['n_product_count'][$key])*intval($Origin_product->price));
                    }
                }
            }
  
            $model->price = $total_price;
            $model->created_at = date('Y-m-d',strtotime($post['Complectation']['created_at']));
            $model->save(false);
            $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"???????????????? ?? ?????? ????????????????????????  ".$model->name,'/complectation/view?id='.$model->id);
                }
            } 
            $model_nom = new NomenclatureProduct();
            $model_nom->vendor_code = $model->name;
            $model_nom->name = $model->name;
            $model_nom->qty_type_id = 1;
            $model_nom->group_id = 25;
            $model_nom->individual = 'false';
            $model_nom->production_date = date('Y-m-d',strtotime($post['Complectation']['created_at']));
            $model_nom->save(false);

            $model_product = new Product();
            $model_product->nomenclature_product_id = $model_nom->id;
            $model_product->warehouse_id = $post['Complectation']['warehouse_id'];
            $model_product->retail_price = $post['Complectation']['price'];
            if(isset($post['Complectation']['count'])){
                $model_product->price = @$total_price/intval($post['Complectation']['count']);
                $model_product->count = $post['Complectation']['count'];
            } else {
                $model_product->price = @$total_price;
                $model_product->count = 1;
            }
            $model_product->created_at = date('Y-m-d',strtotime($post['Complectation']['created_at']));
            $model_product->status = 1;
            $model_product->save(false);

            $ShippingRequest = new ShippingRequest();
            $ShippingRequest->shipping_type = 2;
            $ShippingRequest->provider_warehouse_id = 0;
            $ShippingRequest->supplier_warehouse_id = $post['Complectation']['warehouse_id'];
            $ShippingRequest->invoice = null;
            $ShippingRequest->count = intval($post['Complectation']['count']);
            $ShippingRequest->supplier_id = 0;
            $ShippingRequest->status = 3;
            if($post['Complectation']['created_at']) {
                $ShippingRequest->created_at = date('Y-m-d', strtotime($post['Complectation']['created_at']));
            } else {
                $ShippingRequest->created_at = date('Y-m-d');
            }
            $for_notice = 0;
            $ShippingRequest->user_id = Yii::$app->user->getId();
            $ShippingRequest->save(false);

            $ShippingProduct = new ShippingProducts();
            $ShippingProduct->product_id = $model_product->id;
            $ShippingProduct->created_at = $model->created_at;
             if(isset($post['Complectation']['count'])){
                $ShippingProduct->count = $post['Complectation']['count'];
            } else {
                 $ShippingProduct->count = 1;
            }
            $ShippingProduct->shipping_type = 7;
            $ShippingProduct->price =  $model_product->price;
            $ShippingProduct->shipping_id = $ShippingRequest->id;
            $ShippingProduct->save(false);
            // for old products 
            $ShippingRequestF = new ShippingRequest();
            $ShippingRequestF->shipping_type = 7;
            $ShippingRequestF->provider_warehouse_id = $post['Complectation']['warehouse_id'];
            $ShippingRequestF->supplier_warehouse_id = 0;
            $ShippingRequestF->invoice = null;
            $ShippingRequestF->count = intval($post['Complectation']['count']);
            $ShippingRequestF->supplier_id = 0;
            $ShippingRequestF->status = 3;
            if($post['Complectation']['created_at']) {
                $ShippingRequestF->created_at = date('Y-m-d', strtotime($post['Complectation']['created_at']));
            } else {
                $ShippingRequestF->created_at = date('Y-m-d');
            }
            $for_notice = 0;
            $ShippingRequestF->user_id = Yii::$app->user->getId();
            $ShippingRequestF->save(false);

         
            if (isset($post['ComplectationProducts']['product_id']) && !empty($post['ComplectationProducts']['product_id'])) {
                foreach ($post['ComplectationProducts']['product_id'] as $key => $nProductId) {
                    if ($post['ComplectationProducts']['n_product_count'][$key]) {
                        $Origin_product = Product::findOne($nProductId);
                        if($Origin_product->nProduct->individual == 'false'){
                            $products = Product::find()->where(['nomenclature_product_id'=>$Origin_product->nomenclature_product_id,'warehouse_id'=>$Origin_product->warehouse_id,'status'=>1])
                                ->andWhere(['<=','created_at',$model->created_at])->orderBy(['created_at'=>SORT_ASC])->all();
                            $total = intval($post['ComplectationProducts']['n_product_count'][$key]);
                            
                            foreach ($products as $produst => $prodval){
                                if($prodval->count >= $total){

                                    $prodval->count = $prodval->count - $total;
                                    $prodval->save(false);

                                    $ComplectationProduct = new ComplectationProducts();
                                    $ComplectationProduct->product_id = $prodval->id;
                                    $ComplectationProduct->n_product_count = $total;
                                    $ComplectationProduct->price = $prodval->price;
                                    $ComplectationProduct->numiclature_id = $prodval->nomenclature_product_id;
                                    $ComplectationProduct->complectation_id = $model->id;
                                    $ComplectationProduct->save(false);

                                    $ShippingProductN = new ShippingProducts();
                                    $ShippingProductN->product_id = $prodval->id;
                                    $ShippingProductN->created_at = $model->created_at;
                                    $ShippingProductN->count = $total;
                                    $ShippingProductN->shipping_type = 7;
                                    $ShippingProductN->price =  $prodval->price;
                                    $ShippingProductN->shipping_id = $ShippingRequestF->id;
                                    $ShippingProductN->save(false);

                                    break;
                                } else {
                                    $total = $total - $prodval->count;
                                    $ComplectationProduct = new ComplectationProducts();
                                    $ComplectationProduct->product_id = $prodval->id;
                                    $ComplectationProduct->n_product_count = $total;
                                    $ComplectationProduct->price = $prodval->price;
                                    $ComplectationProduct->numiclature_id = $prodval->nomenclature_product_id;
                                    $ComplectationProduct->complectation_id = $model->id;
                                    $ComplectationProduct->save(false);
                                    
                                    $ShippingProductN = new ShippingProducts();
                                    $ShippingProductN->product_id =  $prodval->id;
                                    $ShippingProductN->created_at = $model->created_at;
                                    $ShippingProductN->count = $total;
                                    $ShippingProductN->shipping_type = 7;
                                    $ShippingProductN->price =  $prodval->price;
                                    $ShippingProductN->shipping_id = $ShippingRequestF->id;
                                    $ShippingProductN->save(false);

                                    $prodval->count = 0;
                                    $prodval->status = 0;
                                    $prodval->save(false);
                                }
                            }
                        } else {
                            $ComplectationProduct = new ComplectationProducts();
                            $ComplectationProduct->product_id = $Origin_product->id;
                            $ComplectationProduct->n_product_count = 1;
                            $ComplectationProduct->price = $Origin_product->price;
                            $ComplectationProduct->numiclature_id = $Origin_product->nomenclature_product_id;
                            $ComplectationProduct->complectation_id = $model->id;
                            $ComplectationProduct->save(false);

                            $ShippingProductN = new ShippingProducts();
                            $ShippingProductN->product_id = $prodval->id;;
                            $ShippingProductN->created_at = $model->created_at;
                            $ShippingProductN->count = $total;
                            $ShippingProductN->shipping_type = 7;
                            $ShippingProductN->price =  $prodval->price;
                            $ShippingProductN->shipping_id = $ShippingRequestF->id;
                            $ShippingProductN->save(false);

                            //original product reset
                            $Origin_product->count = 0;
                            $Origin_product->status = 0;
                            $Origin_product->save(false);
                        }
                    }
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'model_products' => $model_products,
            'dataWarehouses' => $dataWarehouses,
        ]);
    }

    /**
     * Updates an existing Complectation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"???????????????? ?? ????????????????????????  ".$model->name,'/complectation/view?id='.$model->id);
                }
            } 
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Complectation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Complectation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Complectation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Complectation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
