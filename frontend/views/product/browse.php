<?php

use common\components\ImageClient;
use yii\helpers\Url;
use frontend\widgets\HomeProduct;
use frontend\widgets\ProductWidget;
use common\models\Area;
use common\models\Category;
use common\models\Urls;
use common\models\Banner;
use common\components\TextUtils;

$path = 'uploads/restaurant.json';
$data = file_get_contents($path);
$array = json_decode($data);

$images = [];
if(is_array($array) && count($array) > 0){
	$images = $array;
}

?>


<div class="content">
	<nav class="woocommerce-breadcrumb">
		<a href="https://quangbinhoi.com">Trang chủ</a>
		<?php if($category){ ?>
		&nbsp;/&nbsp;<?= $category->name ?>
		<?php } ?>
		<?php if($keyword){ ?>
		&nbsp;/&nbsp;<?= $keyword ?>
		<?php } ?>
	</nav>
	<section class="cat-box woocommerce-box woocommerce clear">
		<div class="cat-box-content">
			<h1 class="page-title">Món Ăn</h1>
			<div class="term-description">
				<p>Các món ăn ngon, nguyên liệu làm bánh của Quán Bánh Lọc Quảng Bình.</p>
			</div>
			<!-- <p class="woocommerce-result-count">Hiển thị một kết quả duy nhất</p> -->
			<form class="woocommerce-ordering" method="get" acction="<?= explode('?', $_SERVER['REQUEST_URI'])[0] ?>">
				<input type="hidden" name="cid" value="<?= $cid ?>">
				<select class="form-control" name="sort" onchange="this.form.submit()">
					<option value="0">Tất cả</option>
					<option <?= $sort=='moi-nhat'?'selected':'' ?> value="moi-nhat">Mới nhất</option>
					<option <?= $sort=='thap-nhat'?'selected':'' ?> value="thap-nhat">Giá từ thấp đến cao</option>
					<option <?= $sort=='cao-nhat'?'selected':'' ?> value="cao-nhat">Giá từ cao xuống thấp</option>
					<option <?= $sort=='xem-nhieu'?'selected':'' ?> value="xem-nhieu">Xem nhiều nhất</option>
				</select>
			</form>
			<div class="clear"></div>

			<ul class="products">
				<?php foreach ($products as $product) { ?>
				<li class="post-<?= $product->id ?> product">
					<a href="<?= $product->createUrl() ?>" class="woocommerce-LoopProduct-link">
						<div class="product-img">
							<img width="192" height="185" src="/<?= $product->thumbnail ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image tie-appear" alt="thumb" title="thumb">
						</div>
						<h3><?= $product->name ?></h3>
						<span class="price">
							<span class="woocommerce-Price-amount amount">
								<?= number_format($product->price) ?> <span class="woocommerce-Price-currencySymbol">₫</span>
							</span>
						</span>
					</a>
				</li>
				<?php } ?>
			</ul><!--/.products-->
			<div class="clear"></div>
		</div><!-- .cat-box-content /-->
	</section>
</div>
<!-- <div class="c-whitebox__content">
	<div class="c-sidebar-menu">
		<ul>
			<?php foreach ($categories as $cats): ?>
				<li class="">
					<a href="<?= $cats->createUrl() ?>"><?= $cats->name ?><span>(<?= $cats->getCount() ?>)</span></a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
</div> -->