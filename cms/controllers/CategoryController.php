<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Product;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\AuthGroup;
use common\models\UserLog;


class CategoryController extends Controller
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
            'query' => Category::find(),
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
            $model = new Category();
        }else{
            $act = 'Cập nhật';
            $model = Category::findOne($id);
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
        $model = Category::findOne($id);
        if ($model != null) {
            $product = Product::find()->andWhere(['categoryId' => $id])->count();
            if($product == 0){
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
