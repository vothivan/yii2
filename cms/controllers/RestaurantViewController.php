<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Product;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\BoxPromotion;


class RestaurantViewController extends Controller
{

    public function behaviors(){
        $this->checkAuth();
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $this->view->title = 'Danh sách hình ảnh';

        $path = realpath(dirname(__FILE__).'/../../') . '/frontend/web/uploads/restaurant.json';
        $data = file_get_contents($path);
        $array = json_decode($data);
        if(!is_array($array) || count($array) == 0){
            $data = '[]';
        }
        return $this->render('index', ['images' => $data]);
    }

    public function actionUpdate(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $parms = Yii::$app->request->post();
        if(isset($parms['data'])){
            $path = realpath(dirname(__FILE__).'/../../') . '/frontend/web/uploads/restaurant.json';
            file_put_contents($path, $parms['data']);
            return ['success' => true];
        }
        return ['success' => false];
        // $datetime = date('YmdHis');
        // $path = 'uploads/'.$datetime.'.jpg';
    }
}