<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\News;
use common\models\CategoryNews;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\AuthGroup;
use common\models\UserLog;


class CategoryNewsController extends Controller
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
        $this->view->title = 'Danh sách danh mục';
        $dataProvider = new ActiveDataProvider([
            'query' => CategoryNews::find(),
            'pagination' => [
                'pageSize' => 100
            ],
        ]);
        return $this->render('index', [
            'data' => $dataProvider,
        ]);
    }

    public function actionForm($id = ''){
       
            
        if($id == ''){
            $act = 'Thêm mới';
            $model = new CategoryNews();
        }else{
            $act = 'Cập nhật';
            $model = CategoryNews::findOne($id);
            if($model == null){
                Yii::$app->session->setFlash('error', 'Danh mục không tồn tại!');
                return $this->redirect(['category/index']);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash('success', $act.' danh mục thành công!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', $act.' danh mục thất bại!');
            }
        }

        $this->view->title = $act.' danh mục';
        return $this->render('form', [
            'model' => $model,
            'act' => $act,
        ]);
    }

    public function actionDelete($id = 0){
        $model = CategoryNews::findOne($id);
        if ($model != null) {
            $product = News::find()->count();
            if($product == null){
                $model->delete();
                Yii::$app->session->setFlash('success', 'Xóa danh mục thành công!');
            }else{
                Yii::$app->session->setFlash('error', 'Danh mục này đang có '.$product.' sản phẩm. Không thể xóa!');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Xóa danh mục thất bại!');
        }
        return $this->redirect(['index']);
    }
}
