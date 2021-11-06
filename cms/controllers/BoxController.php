<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Product;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\BoxPromotion;


class BoxController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => BoxPromotion::find(),
            'pagination' => [
                'pageSize' => 100
            ],
        ]);
        return $this->render('index', [
            'data' => $dataProvider,
        ]);
    }

    public function actionList($page = 0){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query = BoxPromotion::find();

        $page = intval($page);
        $pageSize = 100;
        $itemCount = $query->count();
        $pageCount = ceil($itemCount / $pageSize);
        if ($pageCount == 0) {
            $pageCount = 1;
        }

        $query->offset($page * $pageSize)->limit($pageSize)->with(['product'])->orderBy('position')->asArray();
        return [
            'success' => true,
            'data' => [
                'boxs' => $query->all(),
            ],
            'page' => $page+1,
            'page_count' => $pageCount,
            'page_item_count' => intval($itemCount),
            'item_per_page' => $pageSize

        ];
    }


    public function actionSave($id = 0){
       Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = BoxPromotion::findOne($id);
        if($model == null){
            $model = new BoxPromotion();
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->save()){
                    return ['success' => true];
                }
            } 
            return ['success' => false, 'data' => $model->errors];
        }
        return ['success' => false, 'message' => 'Có lỗi bất ngờ xảy ra, thử tải lại trang hoặc báo bộ phận kĩ thuật'];
    }

    public function actionRemove($id = 0){
         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = BoxPromotion::findOne($id);
        if ($model != null) {
            $model->delete();
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Sản phẩm không tồn tại!'];
    }
}
