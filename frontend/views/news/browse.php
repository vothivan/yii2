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
		<span class="current">Tin tức</span>
	</div>
	<article class="post-listing post post-442 page type-page status-publish has-post-thumbnail hentry" id="the-post">
		<div class="post-inner">
			<?php if(is_array($products) && count($products) > 0){ ?>
			<?php foreach ($products as $product): ?>
				<article class="item-list">
					<h2 class="post-box-title">
						<a href="<?= $product->createUrl() ?>"><?= $product->name ?></a>
					</h2>
					<p class="post-meta">
						<span class="tie-date"><i class="fa fa-clock-o"></i><?= date("H:i d/m/Y", $product->createTime) ?></span>	
						<span class="post-cats"><i class="fa fa-folder"></i><a href="/tin-tuc" rel="category tag">Tin tức</a></span>
						<span class="post-comments">
							<i class="fa fa-comments"></i>
							<span>
								<span class="screen-reader-text"><?= $product->name ?></span>
							</span>
						</span>
					</p>
					<div class="post-thumbnail tie-appear">
						<a href="<?= $product->createUrl() ?>">
							<img style="width: 310px;height: 165px;" width="310px" height="165px" src="/<?= $product->image ?>" class="attachment-tie-medium size-tie-medium wp-post-image tie-appear" alt="">				<span class="fa overlay-icon"></span>
						</a>
					</div><!-- post-thumbnail /-->	
					<div class="entry">
						<p><?= $product->description ?>...</p>
						<a class="more-link" href="<?= $product->createUrl() ?>">Đọc thêm »</a>
					</div>	
					<div class="clear"></div>
				</article>	
			<?php endforeach; ?>
			<?php } ?>
			<div class="clear"></div>
		</div><!-- .post-inner -->
	</article><!-- .post-listing -->


	<?php if(is_array($products) && count($products) > 0){ ?>
	<div class="pagination">
		<span class="pages">Page <?= $page ?> of <?= $page_count ?></span>
		<?php if($page - 1 > 0 ){ ?>
		<a class="page" title="<?= $page - 1 ?>" href="<?= explode('?', $_SERVER['REQUEST_URI'])[0] ?>?cid=<?= $cid ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>">«</a>
		<?php } ?>
		<?php if($page - 2 > 0 ){ ?>
		<a class="page" title="<?= $page - 2 ?>" href="<?= explode('?', $_SERVER['REQUEST_URI'])[0] ?>?cid=<?= $cid ?>&sort=<?= $sort ?>&page=<?= $page - 2 ?>"><?= $page - 2 ?></a>
		<?php } ?>
		<?php if($page - 1 > 0 ){ ?>
		<a class="page" title="<?= $page - 1 ?>" href="<?= explode('?', $_SERVER['REQUEST_URI'])[0] ?>?cid=<?= $cid ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>">»</a>
		<?php } ?>
		<span class="current"><?= $page ?></span>
		<?php if($page + 1 <= $page_count ){ ?>
		<a class="page" title="<?= $page + 1 ?>" href="<?= explode('?', $_SERVER['REQUEST_URI'])[0] ?>?cid=<?= $cid ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>"><?= $page + 1 ?></a>
		<?php } ?>
		<?php if($page + 2 <= $page_count ){ ?>
		<a class="page" title="<?= $page + 2 ?>" href="<?= explode('?', $_SERVER['REQUEST_URI'])[0] ?>?cid=<?= $cid ?>&sort=<?= $sort ?>&page=<?= $page + 2 ?>"><?= $page + 2 ?></a>
		<?php } ?>
		<?php if($page + 1 <= $page_count ){ ?>
		<a class="page" title="<?= $page + 1 ?>" href="<?= explode('?', $_SERVER['REQUEST_URI'])[0] ?>?cid=<?= $cid ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>">»</a>
		<?php } ?>
	</div>
	<?php } ?>
</div>