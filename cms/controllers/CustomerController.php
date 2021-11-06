<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Category;
use common\models\Customer;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\AuthGroup;
use common\models\UserLog;


class CustomerController extends Controller
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
        $this->view->title = 'Danh sách khách hàng';
        $dataProvider = new ActiveDataProvider([
            'query' => Customer::find(),
            'pagination' => [
                'pageSize' => 100
            ],
        ]);
        return $this->render('index', [
            'data' => $dataProvider,
        ]);
    }

    public function actionForm($id = ''){
       
        $password = '';
        if($id == ''){
            $act = 'Thêm mới';
            $model = new Customer();
            $model->scenario = Customer::SCENARIO_REGISTER;
        }else{
            $act = 'Cập nhật';
            $model = Customer::findOne($id);
            $password = $model->password;
            if($model == null){
                Yii::$app->session->setFlash('error', 'Khách hàng không tồn tại!');
                return $this->redirect(['customer/index']);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            if(strlen(trim($model->password)) > 0){
            }else{
                if($password){
                     $model->password = $password;
                }
            }
            if ($model->validate()){
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->save();
                Yii::$app->session->setFlash('success', $act.' khách hàng thành công!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', $act.' khách hàng thất bại!');
            }
        }
        $model->password = '';
        $this->view->title = $act.' khách hàng';
        return $this->render('form', [
            'model' => $model,
            'act' => $act,
        ]);
    }

    public function actionDelete($id){
        $model = Customer::findOne($id);
        if ($model != null) {
            Yii::$app->session->setFlash('success', 'Xóa khách hàng thành công!');
            $model->delete();
        } else {
            Yii::$app->session->setFlash('error', 'Xóa khách hàng thất bại!');
        }
        return $this->redirect(['index']);
    }
}
