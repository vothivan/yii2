<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\CategoryNews;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\News;


class NewsController extends Controller
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
        $this->view->title = 'Danh sách bài viết';
        return $this->render('index', ['categories' => CategoryNews::find()->where(['status' => 1])->all()]);
    }

    public function actionList($page = 0, $item = 100, $pid = 0, $pname = '', $categoryId = 0){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query = News::find();

        if($pid != 0){
            $query->andWhere(['id' => $pid]);
        }
        if($pname != ''){
            $query->andWhere(['like', 'name', '%'.$pname.'%', false]);
        }
        if($categoryId != 0){
            $query->andWhere(['categoryId' => $categoryId]);
        }


        $page = intval($page);
        $pageSize = $item;
        $itemCount = (clone $query)->count();
        $pageCount = ceil($itemCount / $pageSize);
        if ($pageCount == 0) {
            $pageCount = 1;
        }

        $query->offset($page * $pageSize)->limit($pageSize)->with(['category'])->asArray()->orderBy('id desc');
        return [
            'success' => true,
            'data' => [
                'news' => $query->all(),
            ],
            'page' => $page+1,
            'page_count' => $pageCount,
            'page_item_count' => intval($itemCount),
            'item_per_page' => $pageSize

        ];
    }

    public function actionGet($id = 0){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = News::findOne($id);
        if($model){
            return [
                'success' => true,
                'data' => $model
            ];
        }
        return [
            'success' => false,
            'message' => 'Bài viết không tồn tại!'
        ];
    }

    public function actionSave($id = 0){
       Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = News::findOne($id);
        if($model == null){
            $model = new News();
            $model->staffId = Yii::$app->user->identity->id;
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->createTime = time();
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
        $model = News::findOne($id);
        if ($model != null) {
            $model->delete();
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Bài viết không tồn tại!'];
    }
}
