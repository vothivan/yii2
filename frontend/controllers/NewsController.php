<?php

namespace frontend\controllers;

use common\components\ImageClient;
use common\components\TextUtils;
use common\components\Utils;
use common\models\Area;
use common\models\Country;
use common\models\Order;
use common\models\CategoryNews;
use common\models\News;
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


class NewsController extends Controller {

	public function actionDetail($id = 0, $name, $page = 0, $cid = 0) {
		$product = News::findOne($id);
		if ($product == null)
			throw new \yii\web\NotFoundHttpException();

		$this->view->title = $product->name.' - Bánh lọc Phương Thu. Món ngon Quảng Bình tại Hà Nội';
		$product->view = $product->view +1;
		$product->save(false);
		return $this->render('detail', [
			'product' => $product,
		]);
	}


	public function actionBrowse($pid = 0, $cid = 0, $item = 20, $keyword = '', $sort = '', $page = 0) {

		$this->view->title = 'Tìm kiếm '.$keyword;
		$query = News::find();
		$category = null;
		if($cid != 0){
			$query->orWhere(['like','categories', '['.$cid.',%' ,false]);
			$query->orWhere(['like','categories', '%,'.$cid.',%' ,false]);
			$query->orWhere(['like','categories', '%,'.$cid.']' ,false]);
			$query->orWhere(['like','categories', '['.$cid.']' ,false]);
			$query->orWhere(['categoryId' => $cid]);
			$category = CategoryNews::findOne($cid);
		}

		if($keyword != ''){
			$query->andWhere(['like','name', '%'.$keyword.'%' ,false]);
		}

		$query->orderBy('id desc');
        $query->andWhere(['status' => 0]);

		 $page = intval($page);
        if($page > 0){
        	$page = $page - 1;
        }
        $pageSize = $item;
        $itemCount = (clone $query)->count();
        $pageCount = ceil($itemCount / $pageSize);
        if ($pageCount == 0) {
            $pageCount = 1;
        }

        $query->offset($page * $pageSize);

		$categories = CategoryNews::find()->all();
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
}