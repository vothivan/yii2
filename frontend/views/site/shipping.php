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

$banner = Banner::find()->all();
?>
<div class="content">

	<div xmlns:v="http://rdf.data-vocabulary.org/#" id="crumbs">
		<span typeof="v:Breadcrumb">
			<a rel="v:url" property="v:title" class="crumbs-home" href="/">Home</a></span> 
			<span class="delimiter">/</span> 
			<span class="current">Ship đồ ăn, uống</span>
		</div>

		<article class="post-listing post post-442 page type-page status-publish has-post-thumbnail hentry" id="the-post">

			<div class="post-inner">
				<h1 class="name post-title entry-title" itemprop="itemReviewed" itemscope="" itemtype="http://schema.org/Thing">
					<span itemprop="name">Ship đồ ăn, uống</span>
				</h1>
				<p class="post-meta"></p>
				<div class="clear"></div>

				<div class="entry">

					
					<h4><span style="text-decoration: underline;"><strong>Hướng dẫn đặt hàng:</strong></span></h4>
					<ul>
						<li>Thời gian nhận đặt hàng: Từ 7h đến 21h hàng ngày</li>
						<li>Thời gian giao hàng: Từ 9h đến 20h hàng ngày</li>
						<li>Đối với bánh sống. Quý khách ở xa nên lựa chọn hình thức giao hàng tiết kiệm (nội tỉnh: giao chậm trong ngày; ngoại tỉnh: nhận hàng sau 1 – 2 ngày) để đỡ tốn kém chi phí vận chuyển cho quý khách.</li>
						<li>Đối với bánh chín hấp nóng ăn ngay. Quý khách vui lòng gọi điện trực tiếp, đặt hàng trước 4 tiếng. Cửa hàng sẽ giao hàng vào 11h – 12h (trưa); 16h30 – 19h (tối).</li>
						<li>Đơn hàng số lượng lớn (từ 1000 cái trở lên), quý khách vui lòng đặt hàng trước 4 ngày (giao Hà Nội), trước 6 ngày (giao đi các tỉnh).</li>
						<li>Các sản phẩm khác (tôm, mực, cá biển, bạch tuộc tươi, khô các loại; mắm ruốc; khoai deo…): quý khách vui lòng đặt hàng trước 4 ngày (giao Hà Nội), trước 6 ngày (giao đi các tỉnh).</li>
					</ul>


				</div><!-- .entry /-->	

				<div class="clear"></div>
			</div><!-- .post-inner -->
		</article><!-- .post-listing -->


	</div>