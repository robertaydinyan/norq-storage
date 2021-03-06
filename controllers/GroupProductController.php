<?php

namespace app\controllers;

use app\models\Notifications;
use app\models\Product;
use Yii;
use app\models\GroupProduct;
use app\models\GroupProductSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupProductController implements the CRUD actions for GroupProduct model.
 */
class GroupProductController extends Controller
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
     * Lists all GroupProduct models.
     * @return mixed
     */
    public function actionIndex()
    {

        
 

        if (Yii::$app->request->post()) {

            $form_data = Yii::$app->request->post();
            if(!isset($form_data['update_button'])) {
                $model = new GroupProduct();
                $model->name = $form_data['name'];
                if ($form_data['group_id']) {
                    $model->group_id = $form_data['group_id'];
                }
                $model->save(false);
            } else {
                $model = GroupProduct::find()->where(['id'=>$form_data['id']])->one();
                $model->name = $form_data['name'];
                $model->save(false);
            }
             return $this->redirect(['index']);
        }
        
        $groupProducts = Product::find()->select([
            's_product.id',
            's_product.price',
            's_product.retail_price',
            's_product.supplier_id',
            's_product.mac_address',
            's_product.comment',
            's_product.created_at',
            's_nomenclature_product.name as n_product_name',
            's_nomenclature_product.production_date as n_product_production_date',
            's_nomenclature_product.individual as n_product_individual',
            's_nomenclature_product.qty_type_id as n_product_qty_type',
            's_group_product.name as group_name',
            's_group_product.id as group_id',
            's_warehouse.type as warehouse_type'
        ])
            ->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id`')
            ->leftJoin('s_group_product', '`s_group_product`.`id`= `s_nomenclature_product`.`group_id`')
            ->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_product`.`warehouse_id`');
        $searchModel = new GroupProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $groups = GroupProduct::find()->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);

        return $this->render('index', [
            'tableTreeGroups'=> $tableTreeGroups,
            'groupProducts' => $groupProducts,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
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
     * Displays a single GroupProduct model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Displays a single GroupProduct model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionShowGroupProducts($group_id = null)
    {
        if($group_id) {
            $haveProducts = Product::find()->select([
                's_product.id',
                's_product.price',
                's_product.retail_price',
                's_suppliers_list.name as supplier_name',
                's_product.mac_address',
                's_product.comment',
                's_product.count',
                's_product.created_at',
                's_nomenclature_product.name as n_product_name',
                's_nomenclature_product.production_date as n_product_production_date',
                's_nomenclature_product.individual as n_product_individual',
                's_nomenclature_product.qty_type_id as n_product_qty_type',
                's_group_product.name as group_name',
                's_group_product.id as group_id',
                's_warehouse_types.name as warehouse_type'
            ])
                ->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id`')
                ->leftJoin('s_group_product', '`s_group_product`.`id`= `s_nomenclature_product`.`group_id`')
                ->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_product`.`warehouse_id`')
                ->leftJoin('s_suppliers_list', '`s_suppliers_list`.`id`= `s_product`.`supplier_id`')
                ->leftJoin('s_warehouse_types', '`s_warehouse`.`type`= `s_warehouse_types`.`id`')
                ->where(['s_group_product.id' => $group_id])
                ->AndWhere(['s_product.status' => 1])
                ->AndWhere('s_product.count > 0')
                ->asArray()
                ->all();
        } else {
            $haveProducts = Product::find()->select([
                's_product.id',
                's_product.price',
                's_product.retail_price',
                's_suppliers_list.name as supplier_name',
                's_product.mac_address',
                's_product.comment',
                's_product.count',
                's_product.created_at',
                's_nomenclature_product.name as n_product_name',
                's_nomenclature_product.production_date as n_product_production_date',
                's_nomenclature_product.individual as n_product_individual',
                's_nomenclature_product.qty_type_id as n_product_qty_type',
                's_group_product.name as group_name',
                's_group_product.id as group_id',
                's_warehouse_types.name as warehouse_type'
            ])
                ->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id`')
                ->leftJoin('s_group_product', '`s_group_product`.`id`= `s_nomenclature_product`.`group_id`')
                ->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_product`.`warehouse_id`')
                ->leftJoin('s_suppliers_list', '`s_suppliers_list`.`id`= `s_product`.`supplier_id`')
                ->leftJoin('s_warehouse_types', '`s_warehouse`.`type`= `s_warehouse_types`.`id`')
                ->AndWhere(['s_product.status' => 1])
                ->AndWhere('s_product.count > 0')
                ->asArray()
                ->all();
        }
        $groupProducts = Product::find()->select([
            's_product.id',
            's_product.price',
            's_product.retail_price',
            's_product.supplier_id',
            's_product.mac_address',
            's_product.comment',
            's_product.created_at',
            's_nomenclature_product.name as n_product_name',
            's_nomenclature_product.production_date as n_product_production_date',
            's_nomenclature_product.individual as n_product_individual',
            's_nomenclature_product.qty_type_id as n_product_qty_type',
            's_group_product.name as group_name',
            's_group_product.id as group_id',
            's_warehouse.type as warehouse_type'
        ])
            ->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id`')
            ->leftJoin('s_group_product', '`s_group_product`.`id`= `s_nomenclature_product`.`group_id`')
            ->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_product`.`warehouse_id`');
        $searchModel = new GroupProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $groups = GroupProduct::find()->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);

        return $this->render('group_products', [
            'tableTreeGroups'=> $tableTreeGroups,
            'groupProducts' => $groupProducts,
            'haveProducts' => $haveProducts,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }





    /**
     * Creates a new GroupProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GroupProduct();
        $groupProducts = ArrayHelper::map(GroupProduct::find()->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Notifications::setNotification(1,"???????????????? ?? ?????????????? ?????????? ?? <b>".$model->name."</b> ",'/group-product');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'groupProducts' => $groupProducts
        ]);
    }

    /**
     * Updates an existing GroupProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $groupProducts = ArrayHelper::map(GroupProduct::find()->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Notifications::setNotification(1,"???????????????? ?? ?????????????? ?????????? ?? <b>".$model->name."</b> ",'/group-product');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'groupProducts' => $groupProducts
        ]);
    }

    /**
     * Deletes an existing GroupProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteGroup()
    {
        $form_data = Yii::$app->request->get();
        $id = intval($form_data['id']);
        Notifications::setNotification(1,"???????????? ?? ?????????????? ?????????? ?? <b>".$id."</b> ",'/group-product');
        $this->findModel($id)->delete();
        return true;
    }

    /**
     * Finds the GroupProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GroupProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GroupProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}