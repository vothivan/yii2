<?php

namespace frontend\controllers;

use frontend\components\Controller;
use yii\helpers\Json;
use common\models\Customer;
use common\models\Order;
use common\models\Product;
use common\models\Category;
use common\models\Rating;
use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use frontend\models\ChangepasswordForm;
use yii\web\Response;



class UserController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'save', 'get', 'getlocations', 'order'],
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionSave(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$model = Customer::findOne(Yii::$app->user->id);
		$model->scenario = Customer::SCENARIO_UPDATE;
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				if ($model->save()) {
					return ['success' => true];
				}
			} else {
				return ['success' => false, 'data' => $model->errors];
			}
		}

		return ['success' => false, 'message' => 'Dữ liệu không đúng'];
	}

	public function actionGet(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['success' => true, 'data' => Customer::findOne(Yii::$app->user->id)];

	}

	public function actionGetorder(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['success' => true, 'data' => Order::findOne(Yii::$app->user->id)];

	}

	public function actionGetlocations()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return [
			'success' => true,
			'data' => [
				'areas' => Area::find()->orderBy('name ASC')->all(),
				'provinces' => Province::find()->orderBy('name ASC')->all(),
				'districts' => District::find()->orderBy('name ASC')->all(),
				'wards' => Ward::find()->orderBy('id ASC')->all()
			]
		];
	}

	public function actionIndex(){
		Yii::$app->session->setFlash('usersidebar', 'index');
		$this->view->title = 'Thông tin cá nhân';
		$this->view->params['description'] = "";
		$this->clientScript .= '$(".menu-left li").removeClass("active");$(".menu-left li:eq(0)").addClass("active");';


		$model = Customer::findOne(Yii::$app->user->id);
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				if ($model->save()) {
					Yii::$app->session->setFlash('success', 'Cập nhật thông tin thành công!');
				}
			} else{
				Yii::$app->session->setFlash('error', 'Dữ liệu không đúng!');
			}
		}
		return $this->render('user', ['model' => $model]);
	}

	public function actionPassword(){
		$customer = Yii::$app->user->identity;
		if (empty($customer)) {
			return $this->redirect('/');
		}

		Yii::$app->session->setFlash('usersidebar', 'password');
		$this->view->title = 'Đổi mật khẩu';
		$this->view->params['description'] = "";
		$model = new ChangepasswordForm();
		if(isset($_POST['ChangepasswordForm'])){
			$model->attributes = $_POST['ChangepasswordForm'];
			if($model->validate()){
				$customer->password = Yii::$app->getSecurity()->generatePasswordHash($model->newpass);
				$customer->update(false);
				$model = new ChangepasswordForm();
				Yii::$app->session->setFlash('success', 'Thay đổi mật khẩu thành công!');
			}
		}
		$this->clientScript .= '$(".menu-left li").removeClass("active");$(".menu-left li:eq(1)").addClass("active");';
		return $this->render('password', ['model' => $model]);
	}

	public function actionOrder($page = 0, $from = 0, $to = 0, $type = 0)
	{
		Yii::$app->session->setFlash('usersidebar', 'order');
		$this->view->title = 'Hóa đơn';
		$this->view->params['description'] = "";
		$this->clientScript .= '$(".menu-left li").removeClass("active");$(".menu-left li:eq(2)").addClass("active");';

		return $this->render('order');
	}

	 public function actionListorder($page = 0, $item = 100, $oid = 0, $name = '', $status = -1){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query = Order::find();

       	$query->andWhere(['customerId' => Yii::$app->user->id]);
        $count['all'] = (clone $query)->count();

        if($oid != 0){
            $query->andWhere(['id' => $oid]);
        }
        if($name != 0){
            $query->orWhere(['contactName' => $name])->orWhere(['contactPhone' => $name])->orWhere(['contactEmail' => $name]);
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

        $page = intval($page);
        if($page > 0){
        	$page = $page - 1;
        }
        $pageSize = $item;
        $itemCount = $query->count();
        $pageCount = ceil($itemCount / $pageSize);
        if ($pageCount == 0) {
            $pageCount = 1;
        }

        $query->offset($page * $pageSize)->limit($pageSize)->with([
        	'products' => function($q){
        		$q->with(['rating']);
        	}
        ])->asArray()->orderBy('id desc');

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

    public function actionRating(){
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	$model = new Rating();
		if ($model->load(Yii::$app->request->post())) {
			$model->createTime = time();
			$model->customerId = Yii::$app->user->id;
			if ($model->validate()) {
				if ($model->save()) {
					$sum = Rating::find()->andWhere(['productId' => $model->productId])->sum('rating');
					$sum = intval($sum);
					$count = Rating::find()->andWhere(['productId' => $model->productId])->count();
					if($sum == 0 && $count == 0){
						$reRate = 0;
					}else{
						$reRate = ceil((($sum/($count*5))*100)*5/100);
					}
					$product = Product::findOne($model->productId);
					$product->rating = $reRate;
					$product->save(false);
					return ['success' => true, 'message' => 'Cảm ơn bạn đã sử dụng và đánh giá sản phẩm của shop!'];
				}
			}
		}
		return ['success' => false, 'data' => $model->errors];
    }
}
