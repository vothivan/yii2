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

?>
<div class="content">
	<div xmlns:v="http://rdf.data-vocabulary.org/#" id="crumbs">
		<span typeof="v:Breadcrumb">
			<a rel="v:url" property="v:title" class="crumbs-home" href="/">Home</a>
		</span> 
		<span class="delimiter">/</span> 
		<span class="current"><?= $product->category->name ?></span>
	</div>
	<article class="post-listing post post-442 page type-page status-publish has-post-thumbnail hentry" id="the-post">
		<div class="post-inner">
			<div class="product">
				<div class="images">
					<a href="" itemprop="image" class="woocommerce-main-image zoom" title="" rel="lightbox-enabled[product-gallery]">
						<!-- <img width="100%" height="185" src="<?= $product->image ?>" class="attachment-shop_single size-shop_single wp-post-image tie-appear" alt="" title=""> -->
						<img id="myCloudZoom" class="cloudzoom" src="<?= $product->image ?>" data-cloudzoom ="zoomSizeMode: 'image',zoomPosition:'inside',zoomOffsetX:0, zoomImage: '<?= $product->image ?>'" alt="" />
					</a>	
					<!-- <div class="thumbnails columns-3">
						<a href="https://quangbinhoi.com/wp-content/uploads/2014/07/2.jpg" class="zoom first" title="" rel="lightbox-enabled[product-gallery]">
							<img width="200" height="200" src="https://quangbinhoi.com/wp-content/uploads/2014/07/2-200x200.jpg" class="attachment-shop_thumbnail size-shop_thumbnail tie-appear" alt="2" title="2" caption="" url="https://quangbinhoi.com/wp-content/uploads/2014/07/2.jpg" srcset="https://quangbinhoi.com/wp-content/uploads/2014/07/2-200x200.jpg 200w, https://quangbinhoi.com/wp-content/uploads/2014/07/2-150x150.jpg 150w" sizes="(max-width: 200px) 100vw, 200px">
						</a>
						<a href="https://quangbinhoi.com/wp-content/uploads/2014/07/3-2.jpg" class="zoom" title="" rel="lightbox-enabled[product-gallery]">
							<img width="200" height="200" src="https://quangbinhoi.com/wp-content/uploads/2014/07/3-2-200x200.jpg" class="attachment-shop_thumbnail size-shop_thumbnail tie-appear" alt="3" title="3" caption="" url="https://quangbinhoi.com/wp-content/uploads/2014/07/3-2.jpg" srcset="https://quangbinhoi.com/wp-content/uploads/2014/07/3-2-200x200.jpg 200w, https://quangbinhoi.com/wp-content/uploads/2014/07/3-2-150x150.jpg 150w" sizes="(max-width: 200px) 100vw, 200px">
						</a>
						<a href="https://quangbinhoi.com/wp-content/uploads/2014/07/4-1.jpg" class="zoom last" title="" rel="lightbox-enabled[product-gallery]">
							<img width="200" height="200" src="https://quangbinhoi.com/wp-content/uploads/2014/07/4-1-200x200.jpg" class="attachment-shop_thumbnail size-shop_thumbnail tie-appear" alt="4" title="4" caption="" url="https://quangbinhoi.com/wp-content/uploads/2014/07/4-1.jpg" srcset="https://quangbinhoi.com/wp-content/uploads/2014/07/4-1-200x200.jpg 200w, https://quangbinhoi.com/wp-content/uploads/2014/07/4-1-150x150.jpg 150w" sizes="(max-width: 200px) 100vw, 200px">
						</a>
					</div> -->
				</div>
				<div class="summary entry-summary">
					<h1 itemprop="name" class="product_title entry-title"><?= $product->name ?></h1>
					<div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
						<p class="price">
							<span class="woocommerce-Price-amount amount">
								<?= number_format($product->price) ?><span class="woocommerce-Price-currencySymbol">₫</span>
							</span>
						</p>
						<meta itemprop="price" content="<?= $product->price ?>">
						<meta itemprop="priceCurrency" content="VND">
						<link itemprop="availability" href="https://schema.org/InStock">
					</div>
					<div itemprop="description">
						<?= $product->description ?>
					</div>
					<div class="product_meta">
						<span class="posted_in">Danh mục: <a href="" rel="tag"><?= $product->category->name ?></a></span>
						<span class="tagged_as">Từ khóa: <?= $product->keywords ?></span>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="entry">
				<div class="woocommerce-tabs wc-tabs-wrapper">
					<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab" id="tab-description" style="display: block;">
						<h2>Mô tả sản phẩm</h2>
						<?= $product->description2 ?>
					</div>
				</div>
			</div><!-- .entry /-->	
			<div class="entry">
				<fb:comments href="https://banhlocphuongthu.com/<?= $product->createUrl() ?>" colorscheme="light" numposts="10" width="100%"></fb:comments>
			</div><!-- .entry /-->	
			<div class="clear"></div>
		</div><!-- .post-inner -->
	</article><!-- .post-listing -->
</div>