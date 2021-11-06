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
			<h1 class="name post-title entry-title" itemprop="itemReviewed" itemscope="" itemtype="http://schema.org/Thing">
				<span itemprop="name"><?= $product->name ?></span>
			</h1>
			<p class="post-meta">
				<span class="post-meta-author"><i class="fa fa-user"></i><a href="#" title=""><?= $product->staff->name ?></a></span>
				<span class="tie-date"><i class="fa fa-clock-o"></i><?= date("H:i d/m/Y", $product->createTime) ?></span>	
				<span class="post-cats"><i class="fa fa-folder"></i><a href="/tin-tuc" rel="category tag">Tin tức</a></span>
				<span class="post-comments">
					<i class="fa fa-comments"></i>
					<span>
						<span class="screen-reader-text"><?= $product->name ?></span>
					</span>
				</span>
				<span class="post-views"><i class="fa fa-eye"></i><?= $product->view ?> lượt xem</span> 
			</p>
			<div class="clear"></div>
			<div class="entry">
				<?= $product->description2 ?>
			</div><!-- .entry /-->	
			<div class="entry">
				<fb:comments href="https://banhlocphuongthu.com/<?= $product->createUrl() ?>" colorscheme="light" numposts="10" width="100%"></fb:comments>
			</div><!-- .entry /-->	
			<div class="clear"></div>
		</div><!-- .post-inner -->
	</article><!-- .post-listing -->
</div>