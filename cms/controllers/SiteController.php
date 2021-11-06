<?php

namespace cms\controllers;

use cms\components\Controller;
use Yii;
use yii\filters\AccessControl;
use common\models\Staff;
use yii\helpers\Json;
use common\components\Utils;
use cms\models\ChangepasswordForm;

class SiteController extends Controller
{

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionPing(){
        return Json::encode(['success' => Yii::$app->user->isGuest]);
    }

    public function actionIndex(){
        $this->view->title = "Hệ thống quản trị";
        return $this->render('index');
    }


    public function actionLogin(){
        $this->layout = 'empty';
        $this->view->title = 'Đăng nhập quản trị';
        $params = Yii::$app->request->post();
        if ($params != null) {
            $username = @$params['username'];
            $password = @$params['password'];
            $remember = @$params['remember'];
            if ($username == null || $password == null || $username == '' || $password == '') {
                Yii::$app->session->setFlash('error', 'Bạn chưa nhập đủ thông tin!');
            } else {
                $user = Staff::find()->andWhere(['phone' => $username])->one();
                if($user == null){
                    $user = Staff::find()->andWhere(['email' => $username])->one();
                }
                if ($user == null) {
                    Yii::$app->session->setFlash('error', 'Thông tin tài khoản hoặc mật khẩu không chính xác!');
                }else if ($user->status == 0) {
                    Yii::$app->session->setFlash('error', 'Tài khoản của bạn không có quyền đăng nhập!');
                } else {
                    if (Yii::$app->security->validatePassword($password, $user->password)) {
                        Yii::$app->user->login($user, $remember == 'on' ? 3600 * 24 * 365 : 0);
                        $user->lastLoginTime = time();
                        $user->save();
                        $this->goBack();
                    } else {
                        Yii::$app->session->setFlash('error', 'Thông tin tài khoản hoặc mật khẩu không chính xác!');
                    }
                }
            }
        }
        return $this->render('login');
    }

    public function actionChangepassword(){
        $this->view->title = "Thay đổi mật khẩu";
        $model = new ChangepasswordForm();
        if(isset($_POST['ChangepasswordForm'])){
            $model->attributes = $_POST['ChangepasswordForm'];
            if($model->validate()){
                $user = Staff::findOne(Yii::$app->user->identity->id);
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->newpass);
                $user->update(false);
                $model = new  ChangepasswordForm();
                Yii::$app->session->setFlash('success', 'Thay đổi mật khẩu thành công!');
            }
        }
        return $this->render('changepassword', ['model' => $model]);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        $this->goHome();
    }
}
