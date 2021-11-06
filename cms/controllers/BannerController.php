<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Product;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\Banner;


class BannerController extends Controller
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
        $this->view->title = 'Danh sách sản phẩm';
        $model = Banner::find()->all();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionSave($id = 0){
       Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Banner::findOne($id);
        if($model != null){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if($model->save()){
                        return ['success' => true];
                    }
                } 
                return ['success' => false, 'data' => $model->errors];
            }
        }
        return ['success' => false];
    }
}
