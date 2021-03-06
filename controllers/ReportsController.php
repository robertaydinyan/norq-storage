<?php

namespace app\controllers;

use app\models\User;
// use app\modules\billing\models\Regions;
use app\models\Product;
use app\models\ShippingType;
use app\models\Warehouse;
use app\models\WarehouseGroups;
use app\models\WarehouseTypes;
use Yii;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * QtyTypeController implements the CRUD actions for QtyType model.
 */
class ReportsController extends Controller
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
     * Lists all QtyType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $shipping_types=  ShippingType::find()->all();
        $warehouse_types = ArrayHelper::map(WarehouseTypes::find()->asArray()->all(), 'id', 'name');
        $regions = []; //ArrayHelper::map(Regions::find()->asArray()->all(), 'id', 'name');
        $groups = ArrayHelper::map(WarehouseGroups::find()->asArray()->all(), 'id', 'name');
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->all(), 'id', 'name');

        $get = Yii::$app->request->get();
        $data = false;
        if(!empty($get)){
            $data = Product::findByData($get);
        }
        return $this->render('index', [
            'shipping_types' => $shipping_types,
            'warehouse_types' => $warehouse_types,
            'users' =>$uersData,
            'regions' =>$regions,
            'groups' =>$groups,
            'data' =>$data,
        ]);
    }
    public function actionGenerate(){
        $get = Yii::$app->request->get();
        $data = false;
        if(!empty($get)){
            $data = Product::findByData($get);
        }
      return $this->renderAjax('generate', ['data' =>$data]);
    }

}
