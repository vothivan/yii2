<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\Card;


class CardController extends Controller
{

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionList($page = 0, $item = 100, $cid = 0, $ccarrier = 0, $cprice= 0, $cname = '', $cardId = 0){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query = Card::find();

        if($cid != 0){
            $query->andWhere(['id' => $cid]);
        }
        if($cprice != ''){
            $query->andWhere(['price' => $cprice]);
        }
        if($cname != ''){
            $query->andWhere(['name' => $cname]);
        }

		if($ccarrier != ''){
            $query->andWhere(['like', 'carrier', '%'.$ccarrier.'%', false]);
        }

        $page = intval($page);
        $pageSize = $item;
        $itemCount = $query->count();
        $pageCount = ceil($itemCount / $pageSize);
        if ($pageCount == 0) {
            $pageCount = 1;
        }

       $query->offset($page * $pageSize)->limit($pageSize)->asArray();
        return [
            'success' => true,
            'data' => [
                'cards' => $query->all(),
            ],
            'page' => $page+1,
            'page_count' => $pageCount,
            'page_item_count' => intval($itemCount),
            'item_per_page' => $pageSize

        ];
    }
    
    public function actionGet($id = 0){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Card::findOne($id);
        if($model){
            return [
                'success' => true,
                'data' => $model
            ];
        }
        return [
            'success' => false,
            'message' => 'Sản phẩm không tồn tại!'
        ];
    }

    public function actionSave($id = 0){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Card::findOne($id);
        if($model == null){
            $model = new Card();
        }
        if ($model->load(Yii::$app->request->post())) {
           // $model->createTime = time();
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
       $model = Card::findOne($id);
       if ($model != null) {
           $model->delete();
           return ['success' => true];
       }
       return ['success' => false, 'message' => 'Sản phẩm không tồn tại!'];
   }
   
}
