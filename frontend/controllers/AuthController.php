<?php

namespace frontend\controllers;

use common\components\ImageClient;
use common\components\TextUtils;
use common\components\Utils;
use common\models\Area;
use common\models\Country;
use common\models\Keyword;
use common\models\Category;
use common\models\Product;
use common\models\ProductSearch;
use common\models\Province;
use common\models\Merchant;
use common\models\ProductComment;
use common\models\Customer;
use frontend\components\Controller;
use Yii;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;


class AuthController extends Controller {


	public function actionSignin(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$email = @Yii::$app->request->post()['email'];
		$password = @Yii::$app->request->post()['password'];
		$remember = @Yii::$app->request->post()['remember'];

		if ($email == null || $password == null) {
			return ['success' => false, 'message' => 'Bạn chưa nhập đầy đủ thông tin'];
		}
		$customer = Customer::findOne(['email' => $email]);
		if($customer == null){
			$customer = Customer::findOne(['phone' => $email]);
		}
		if ($customer == null) {
			return ['success' => false, 'message' => 'Thông tin tài khoản hoặc mật khẩu không chính xác!'];
		} else {
			if (Yii::$app->getSecurity()->validatePassword($password, $customer->password)) {
				Yii::$app->user->login($customer, $remember != null ? 3600 * 24 * 365 : 0);

				return ['success' => true,'message'=> 'Đăng nhập thành công!'];
			} else {
				return ['success' => false, 'message' => 'Sai mật khẩu'];
			}
		}
	}

	public function actionSignup(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$model = new Customer();
		$model->scenario = Customer::SCENARIO_REGISTER;
		if ($model->load(\Yii::$app->request->post())) {
			$model->lastLoginTime = time();
			$model->status = 1;
			if ($model->validate()) {
				if ($model->password != null && $model->password != '') {
					$model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
				}
				if ($model->save(false)) {
					Yii::$app->user->login($model, 3600 * 24 * 365);
					$user = Yii::$app->user->identity;
					unset($user->password);
					return ['success'=>true,'message'=>'Đăng ký tài khoản thành công', 'user'=>$user];
				}
			}
			return ['success' => false, 'data' => $model->errors];
		}
		return ['success' => false, 'message' => 'Dữ liệu không hợp lệ'];
	}
	
	public function actionSignout(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		Yii::$app->user->logout();
		return ['success' => true];
	}
}