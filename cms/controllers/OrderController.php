<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\Product;
use common\models\Order;


class OrderController extends Controller
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
        return $this->render('index', ['categories' => Category::find()->where(['status' => 1])->all()]);
    }

    public function actionList($page = 0, $item = 100, $oid = 0, $name = '', $status = -1){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query = Order::find();
        $count['all'] = (clone $query)->count();

        if($oid != 0){
            $query->andWhere(['id' => $oid]);
        }
        if($name != 0){
            $query->orWhere(['contactName' => $name])->orWhere(['contactPhone' => $name])->orWhere(['contactEmail' => $name]);
        }

        $page = intval($page);
        $pageSize = $item;
        $itemCount = $query->count();
        $pageCount = ceil($itemCount / $pageSize);
        if ($pageCount == 0) {
            $pageCount = 1;
        }

        $count[0] = (clone $query)->count();
        $count[1] = (clone $query)->andWhere(['status'=>0])->count();
        $count[2] = (clone $query)->andWhere(['status'=>1])->count();
        $count[3] = (clone $query)->andWhere(['status'=>2])->count();
        $count[4] = (clone $query)->andWhere(['status'=>3])->count();
        $count[5] = (clone $query)->andWhere(['status'=>4])->count();

        if($status != -1){
            $query->andWhere(['status' => $status]);
        }

        $query->offset($page * $pageSize)->limit($pageSize)->with('products')->asArray()->orderBy('id desc');

        return [
            'success' => true,
            'orders' => $query->all(),
            'page' => $page+1,
            'page_count' => $pageCount,
            'page_item_count' => intval($itemCount),
            'item_per_page' => $pageSize,
            'count' => $count,
        ];
    }

    public function actionChangestatus(){
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $params = Yii::$app->request->post();

        if(isset($params['id']) && isset($params['status'])){
        	$model = Order::findOne($params['id']);
        	if($model != null){
        		$status = intval($params['status']);
        		// var_dump($status);
        		// die;
        		switch ($status) {
        			case 1:
        				$model->confirmTime = time();
        				break;
        			case 2:
        				break;
        			case 3:
        				$model->doneTime = time();
        				break;
        			case 4:
        				$model->cancelTime = time();
        				break;
        			default:
        				break;
        		}
        		$model->status = $status;
        		$model->save(false);
        		return ['success' => true];
        	}
        }
        return ['success' => false];
    }

    public function actionSave($id = 0){
       Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Product::findOne($id);
        if($model == null){
            $model = new Product();
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
}
