<?php
// created for queries for place(country, region, address...)
namespace app\controllers;
use app\models\BaseQuery;

use yii\web\Controller;
use Yii;

class PlaceController extends Controller {
    /**
     * @return array
     */
    public function actionGetRegionsByCountry() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $post = Yii::$app->request->post();
        $post['id'] = 1;
        if (empty($post['id'])) {
            return [];
        }
        return BaseQuery::renderRegions($post['id']);
    }

    /**
     * @return array|array[]
     */
    public function actionGetCitiesByRegion() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();

        if (empty($post['id'])) {
            return [];
        }

        return BaseQuery::renderCities($post['id']);
    }

    /**
     * @return array|array[]
     */
    public function actionGetStreetsByCity() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();
        $data = [];
        if (empty($post['id'])) {
            return [];
        }
        $data['streets'] = BaseQuery::renderStreets($post['id']);
        $data['communities'] = BaseQuery::renderCommunity($post['id']);

        return $data;
    }

    /**
     * @return array|array[]
     */
    public function actionGetStreetsByCommunity() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = [];
        $post = Yii::$app->request->post();
        if (empty($post['id'])) {
            return [];
        }
        $data['streets'] = BaseQuery::renderStreets($post['id'], true);

        return $data;
    }
    
}