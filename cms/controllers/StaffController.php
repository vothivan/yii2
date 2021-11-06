<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Category;
use common\models\Staff;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\AuthGroup;
use common\models\UserLog;


class StaffController extends Controller
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
        $this->view->title = 'Danh sách tài khoản';
        $dataProvider = new ActiveDataProvider([
            'query' => Staff::find(),
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
        $authArr = [];
        if($id == ''){
            $act = 'Thêm mới';
            $model = new Staff();
            $model->scenario = Staff::SCENARIO_REGISTER;
        }else{
            $act = 'Cập nhật';
            $model = Staff::findOne($id);
            $model->scenario = Staff::SCENARIO_UPDATE;
            $password = $model->password;
            if($model == null){
                Yii::$app->session->setFlash('error', 'Tài khoản không tồn tại!');
                return $this->redirect(['customer/index']);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->auths = '[]';
            $auths = Yii::$app->request->post();
            if(isset($auths['auths'])){
                if(is_array($auths['auths']) && count($auths['auths']) > 0){
                    $model->auths = json_encode($auths['auths'],true);
                }
            }

            if ($model->validate()) {
                if(strlen(trim($model->password)) > 0){
                    $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                }else{
                    if($password){
                       $model->password = $password;
                   }
               }
                $model->save(false);
                Yii::$app->session->setFlash('success', $act.' tài khoản thành công!');
                // return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', $act.' tài khoản thất bại!');
            }
        }

        $model->password = '';
        $authArr = json_decode($model->auths);
        $this->view->title = $act.' tài khoản';
        return $this->render('form', [
            'model' => $model,
            'authArr' => $authArr,
            'act' => $act,
        ]);
    }

    public function actionDelete($id){
        $model = Staff::findOne($id);
        if ($model != null) {
            Yii::$app->session->setFlash('success', 'Xóa tài khoản thành công!');
            $model->delete();
        } else {
            Yii::$app->session->setFlash('error', 'Xóa tài khoản thất bại!');
        }
        return $this->redirect(['index']);
    }
}
