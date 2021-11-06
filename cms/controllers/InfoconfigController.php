<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\CMSUser;
use common\models\InfoConfig;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class InfoconfigController extends Controller
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

    public function actionIndex()
    {
        $this->view->title = 'Cập nhật thông tin đơn vị vận hành sàn';
       $model = InfoConfig::findOne(1);
       $before = InfoConfig::findOne(1);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->update();
                Yii::$app->session->setFlash('success', 'Cập nhật thông tin thành công!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Cập nhật thông tin thất bại!');
            }
        }
        return $this->render('edit', [ 'model' => InfoConfig::getInfo()]);
    }
}
