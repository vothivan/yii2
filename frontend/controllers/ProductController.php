<?php

namespace frontend\controllers;

use common\components\ImageClient;
use common\components\TextUtils;
use common\components\Utils;
use common\models\Area;
use common\models\Country;
use common\models\Order;
use common\models\Category;
use common\models\Product;
use common\models\ProductSearch;
use common\models\Province;
use common\models\Merchant;
use common\models\ProductComment;
use common\models\OrderProduct;
use frontend\components\Controller;
use Yii;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;


class ProductController extends Controller {

	public function actionDetail($id = 0, $name, $page = 0, $cid = 0) {
		$product = Product::findOne($id);
		if ($product == null)
			throw new \yii\web\NotFoundHttpException();

		$this->view->title = $product->name.' - Bánh lọc Phương Thu. Món ngon Quảng Bình tại Hà Nội';
		$product->view = $product->view +1;
		$product->save(false, ['view']);
		return $this->render('detail', [
			'product' => $product,
		]);
	}


	public function actionBrowse($pid = 0, $cid = 0, $item = 20, $keyword = '', $sort = '', $page = 0) {

		$this->view->title = 'Tìm kiếm '.$keyword;
		$query = Product::find();
		$query->select('id, name, price, categoryId, price, view, status, image, thumbnail');
		$category = null;
		if($cid != 0){
			$query->orWhere(['like','categories', '['.$cid.',%' ,false]);
			$query->orWhere(['like','categories', '%,'.$cid.',%' ,false]);
			$query->orWhere(['like','categories', '%,'.$cid.']' ,false]);
			$query->orWhere(['like','categories', '['.$cid.']' ,false]);
			$query->orWhere(['categoryId' => $cid]);
			$category = Category::findOne($cid);
			
			if(!$keyword){
				$this->view->title = $category->name;
			}
		}

		if($keyword != ''){
			$query->andWhere(['like','name', '%'.$keyword.'%' ,false]);
		}

		$query->orderBy('id desc');
		if($sort != ''){
			switch ($sort) {
				case 'moi-nhat':
					$query->orderBy('id');
				break;
				case 'thap-nhat':
					$query->orderBy('price');
				break;
				case 'cao-nhat':
					$query->orderBy('price desc');
				break;
				case 'xem-nhieu':
					$query->orderBy('view desc');
				break;
			}
		}


        $query->andWhere(['status' => 0]);

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

        $query->offset($page * $pageSize);

		$categories = Category::find()->select('id, name')->all();
		return $this->render('browse', [
			'products' => $query->limit($item)->all(),
			'category' => $category,
			'categories' => $categories,
			'keyword' => $keyword,
			'cid' => $cid,
			'sort' => $sort,
			'page' => $page+1,
            'page_count' => $pageCount,
            'page_item_count' => intval($itemCount),
            'item_per_page' => $pageSize,
		]);

	}

	public function actionCart() {
				$this->view->title = 'Giỏ hàng';
		return $this->render('cart');
	}

	public function actionListincart() {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$params = Yii::$app->request->post('Data');

		$arr = json_decode($params);
		$products = [];
		if(count($arr) > 0){
			foreach ($arr as $p) {
				$ids[] = $p->pid;
			}
			$products = Product::find()->andWhere(['id' => $ids])->all();
		}
		return ['success' => true, 'data' => $products];
	}

	public function actionBill($oid = 0) {
		$this->layout = 'empty';
		$model = Order::findOne($oid);
		if($model == null){
			$this->redirect(['site/index']);
			die;
		}

		return $this->render('bill',['model' => $model]);
	}

	public function actionBuy() {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$params = Yii::$app->request->post();

		$order = new Order();
		if($order->load($params)){
			$order->status = 0;
			$order->customerId = 0;
			$order->totalPrice = 0;
			if(!Yii::$app->user->isGuest){
				$order->customerId = Yii::$app->user->id;
			}

			if($order->validate()){
				if($order->save()){
					$carts = json_decode($params['Cart']);
					if(is_array($carts) && count($carts) > 0){
						foreach ($carts as $cart) {
							$product = Product::findOne(intval($cart->pid));
							if($product == null || intval($cart->quantity) <= 0){
								$order->delete();
								return ['success' => false, 'message' => 'Phát hiện dữ liệu sai, đơn hàng không thể khởi tạo!'];
							}
							$op = new OrderProduct();
							$op->orderId = $order->id;
							$op->productId = $product->id;
							$op->productData = Json::encode($product);
							$op->name = $product->name;
							$op->quantity = intval($cart->quantity);
							$op->price = $product->price;
							$op->save();
							$order->totalPrice += $product->price * intval($cart->quantity);
						}
					}
					$order->createTime = time();
					$order->save();
					return ['success' => true, 'message' => 'Khởi tạo đơn hàng thành công!', 'orderId' => $order->id];
				}
			}
		}
		return ['success' => false, 'data' => $order->errors];
	}
}