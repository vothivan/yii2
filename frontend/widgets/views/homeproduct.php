<?php

use yii\helpers\Url;
use common\components\ImageClient;
use common\models\ProductSearch;

?>
<?php if($product){ ?>
<li>
	<div class="c-product-item">
		<div class="c-product-item__shadow">
			<div class="c-product-item__thumb">
				<?php if($product->listPrice && $product->listPrice > $product->price){ 
					$percent = ceil(100-($product->price/$product->listPrice*100));
					?>
					<span class="c-tag-sale"><b>Giảm</b><?=$percent?>%</span>
					<?php } ?>
					<a href="<?= $product->createUrl() ?>"><img src="<?= ImageClient::thumb($product->image, 500, 500) ?>" alt="<?= $product->name ?>" /></a>
				</div>
				<div class="c-product-item__content">
					<div class="c-product-item__row">
						<a class="c-product-item__title" href="<?= $product->createUrl() ?>">
							<?php if($product->merchant->isPostmall){ ?>
								<span class="icon-mall"></span>
							<?php } ?>
							<?= $product->name ?></a>
					</div>
					<div class="c-product-item__row">
						<span class="c-product-item__price"><?= number_format($product->price); ?><sup>đ</sup></span>
						<?php if($product->listPrice && $product->listPrice > $product->price){ ?>
						<span class="c-product-item__oldprice"><?= number_format($product->listPrice); ?><sup>đ</sup></span>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</li>
	<?php } ?>