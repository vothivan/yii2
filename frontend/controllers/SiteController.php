<?php

namespace frontend\controllers;

use common\components\ImageClient;
use common\components\TextUtils;
use common\models\Etc;
use common\models\Homebox;
use common\models\Alias;
use common\models\Import;
use common\models\Keyword;
use common\models\Banner;
use common\models\Product;
use common\models\ProductImage;
use common\models\HotProduct;
use common\models\Subscriber;
use common\models\Merchant;
use common\models\CategorySuggest;
use common\models\MerchantHighlight;
use common\models\Smbox;
use frontend\components\Controller;
use common\components\VerifyEmail;
use Yii;
use yii\helpers\Url;
use common\models\Area;
use app\models\Homeboxv2;
use common\models\Category;
use yii\db\Expression;
use common\models\BoxPromotion;


class SiteController extends Controller
{

	// public function behaviors()
	// {

	// 	$clear = Yii::$app->request->get('cache');
	// 	$cacheEnabled = intval($clear) == 1 ? false : Yii::$app->params['cacheEnabled'];
	// 	return [
	// 		[
	// 			'class' => 'yii\filters\PageCache',
	// 			'only' => ['index'],
	// 			'duration' => Yii::$app->params['cacheDuration'],
	// 			'variations' => \Yii::$app->request->get(),
 //                //'enabled' => true
	// 			'enabled' => $cacheEnabled,
	// 		],
	// 	];
	// }


	public function actionIndex(){
		$this->view->title = 'Bánh lọc Phương Thu. Món ngon Quảng Bình tại Hà Nội';
		// $products = Product::find()->andWhere(['status' => 0])->orderBy('position')->limit(15)->all();
		$boxs = BoxPromotion::find()->andWhere(['status' => 1])->with(['product'])->orderBy('position')->all();
		// $this->layout = 'main1';
		return $this->render('index',
			[
				// 'products' => $products,
				'boxs' => $boxs,
			]
		);
	}

	public function actionShipping(){
		$this->view->title = 'Bánh lọc Phương Thu. Món ngon Quảng Bình tại Hà Nội';
		return $this->render('shipping');
	}

	public function actionIntroduce(){
		$this->view->title = 'Bánh lọc Phương Thu. Món ngon Quảng Bình tại Hà Nội';
		return $this->render('introduce');
	}

	public function actionUpload(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		header("Access-Control-Allow-Origin: *");
		// header("Access-Control-Allow-Credentials: true");
		if(!empty($_FILES['file'])){

			$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
			$detectedType = exif_imagetype($_FILES['file']['tmp_name']);
			if(!in_array($detectedType, $allowedTypes)){
				return ['success' => false, 'message' => 'Tệp tin tải lên phải là hình ảnh!'];
			}

			$file = $_FILES['file'];
			$duoi = explode('.', $file['name']);
			$duoi = end($duoi);
			$datetime = date('YmdHis');
			$filename = $datetime.'.jpg';
			$path = 'uploads/'.$datetime.'.jpg';

			$pathThumbnail = 'uploads/thumbnail/'.$datetime.'.jpg';
			move_uploaded_file($_FILES['file']['tmp_name'],$path);

			$thumbnai = null;
			if(isset($_POST['minisize']) && $_POST['minisize']){
				$thumbnai = $this->createThumbnail([
					'path' 		=> $path,
					'pathThumbnail' => $pathThumbnail,
					'filename' 	=> $filename,
					'width' 	=> isset($_POST['width'])?$_POST['width']:0,
					'height' 	=> isset($_POST['height'])?$_POST['height']:0,
					'resize' 	=> isset($_POST['resize'])?$_POST['resize']:1,
					// 'resize' 	=> 2, // 1 resize aspect ratio, 2 resize with width-height
				]);
				$thumbnai = $pathThumbnail;
			}
			return [
				'success' => true,
				'data' => $path,
				'thumb' => $thumbnai,
			];
		}
	}


	private function createThumbnail($arr){
		$path 		= $arr['path'];
		$pathThumbnail 		= $arr['pathThumbnail'];
		$filename 	= $arr['filename'];
		$new_width 	= isset($arr['width']) 	&& intval($arr['width']) > 0		?$arr['width']:320;
		$new_height = isset($arr['height']) && intval($arr['height']) > 0		?$arr['height']:320;
		$resize 	= isset($arr['resize']) && in_array(intval($arr['resize']), [1,2])	?$arr['resize']:1;

		$mime = getimagesize($path);

		if($mime['mime']=='image/png') { 
			$src_img = imagecreatefrompng($path);
		}
		if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
			$src_img = imagecreatefromjpeg($path);
		}   

		$old_x          =   imageSX($src_img);
		$old_y          =   imageSY($src_img);

		if($resize == 1){
			if($old_x > $old_y) 
			{
				$thumb_w    =   $new_width;
				$thumb_h    =   $old_y*($new_height/$old_x);
			}
			if($old_x < $old_y) 
			{
				$thumb_w    =   $old_x*($new_width/$old_y);
				$thumb_h    =   $new_height;
			}
			if($old_x == $old_y) 
			{
				$thumb_w    =   $new_width;
				$thumb_h    =   $new_height;
			}
		}

		if($resize == 2){
			$thumb_w    =   $new_width;
			$thumb_h    =   $new_height;
		}

		$dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
    	// New save location
		if($mime['mime']=='image/png') {
			$result = imagepng($dst_img,$pathThumbnail,8);
		}
		if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
			$result = imagejpeg($dst_img,$pathThumbnail,80);
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img);
		return $result;
	}




	// private function createThumbnail($arr){

	// 	$path 		= $arr['path'];
	// 	$pathThumbnail 		= $arr['pathThumbnail'];
	// 	$filename 	= $arr['filename'];
	// 	$new_width 	= isset($arr['width']) 	&& intval($arr['width']) > 0		?$arr['width']:320;
	// 	$new_height = isset($arr['height']) && intval($arr['height']) > 0		?$arr['height']:320;
	// 	$resize 	= isset($arr['resize']) && in_array($arr['resize'], [1,2])	?$arr['resize']:1;

	// 	$mime = getimagesize($path);
	// 	if($mime['mime']=='image/png') { 
	// 		$src_img = imagecreatefrompng($path);
	// 	}
	// 	if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
	// 		$src_img = imagecreatefromjpeg($path);
	// 	}   
	// 	$old_x          =   imageSX($src_img);
	// 	$old_y          =   imageSY($src_img);

	// 	if($resize === 1){
	// 		if($old_x > $old_y){
	// 			$thumb_w    =   $new_width;
	// 			$thumb_h    =   $old_y*($new_height/$old_x);
	// 		}
	// 		if($old_x < $old_y){
	// 			$thumb_w    =   $old_x*($new_width/$old_y);
	// 			$thumb_h    =   $new_height;
	// 		}
	// 		if($old_x == $old_y){
	// 			$thumb_w    =   $new_width;
	// 			$thumb_h    =   $new_height;
	// 		}
	// 	}
	// 	if($resize === 2){
	// 		$thumb_w    =   $new_width;
	// 		$thumb_h    =   $new_height;
	// 	}

	// 	$dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);
	// 	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
 //    	// New save location
	// 	if($mime['mime']=='image/png') {
	// 		$result = imagepng($dst_img,$pathThumbnail,8);
	// 	}
	// 	if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
	// 		$result = imagejpeg($dst_img,$pathThumbnail,80);
	// 	}
	// 	imagedestroy($dst_img); 
	// 	imagedestroy($src_img);
	// 	// return $result;
	// 	return $pathThumbnail;
	// }




	public function actionKeyword($keyword = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($keyword != null) {
            $keyword = strtolower($keyword);
            $alias = TextUtils::createAlias($keyword);
            $key = Keyword::findOne(['alias' => $alias]);
            if ($key == null) {
                $key = new Keyword();
                $key->alias = $alias;
                $key->keyword = TextUtils::createKeyword($keyword);
                $key->originKeyword = $keyword;
                $key->firstHit = microtime(true);
            }
            $key->hit++;
            $key->lastHit = microtime(true);
            $key->hps = $key->hit / ($key->lastHit - $key->firstHit);
            $key->save();
        }

        return true;
    }

    public function actionVerifyEmail($email = ''){
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	header("Access-Control-Allow-Origin: *");
		// header("Access-Control-Allow-Credentials: true");
    	$vmail = new VerifyEmail();
    	return $vmail->echeck($email);
    }
    
    public function actionAdmin(){
         header('Location: https://admin.banhlocphuongthu.com');
         die;
    }


    public function actionDetect(){
    	echo $_SERVER['HTTP_USER_AGENT'];
    	echo '<br>---------------------------------------------------------------<br>';
    	die;
    	$curl = curl_init();

    	curl_setopt_array($curl, array(
  // CURLOPT_URL => 'http://api.userstack.com/detect?access_key=68d70a2ab9923e39de5285d7f9cfd621&ua=Mozilla/5.0%20(iPhone;%20CPU%20iPhone%20OS%2013_3%20like%20Mac%20OS%20X)%20AppleWebKit/605.1.15%20(KHTML,%20like%20Gecko)%20Mobile/15E148%20%5BFBAN/FBIOS;FBDV/iPhone12,5;FBMD/iPhone;FBSN/iOS;FBSV/13.3;FBSS/3;FBID/phone;FBLC/en_US;FBOP/5;FBCR/AT%2526T%5D&&',
    		CURLOPT_URL => $_SERVER['HTTP_USER_AGENT'],
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_ENCODING => '',
    		CURLOPT_MAXREDIRS => 10,
    		CURLOPT_TIMEOUT => 0,
    		CURLOPT_FOLLOWLOCATION => false,
    		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    		CURLOPT_CUSTOMREQUEST => 'GET',
  // CURLOPT_HTTPHEADER => array(
  //   // 'Cookie: __cfduid=daad7dcb845d29b9b668c7ed2ccfc60d51611104834'
  // ),
    	));

    	$response = curl_exec($curl);

    	curl_close($curl);

    	$arr = json_decode($response);


    	if ($arr->device->type == 'desktop') {
    		echo 'desktop: '. $arr->os->name;
    	} else {
    		echo $arr->name;	
    	}

    	die;
    }
}
