<?php

use common\components\ImageClient;
use yii\helpers\Url;
use frontend\widgets\HomeProduct;
use frontend\widgets\ProductWidget;
use common\models\Area;
use common\models\Category;
use common\models\Urls;
use common\models\Banner;
use common\models\Product;
use common\components\TextUtils;

$path = 'uploads/restaurant.json';
$data = file_get_contents($path);
$array = json_decode($data);

$images = [];
if(is_array($array) && count($array) > 0){
  $images = $array;
}


$products1 = Product::find()
->andWhere(['status' => 0])
->orderBy('position')
->limit(15)
->andWhere(['categoryId' => 6])
->all();

$products2 = Product::find()
->andWhere(['status' => 0])
->orderBy('position')
->limit(15)
->andWhere(['categoryId' => 1])
->all();

$products3 = Product::find()
->andWhere(['status' => 0])
->orderBy('position')
->limit(15)
->andWhere(['categoryId' => 8])
->all();

$products4 = Product::find()
->andWhere(['status' => 0])
->orderBy('position')
->limit(15)
->andWhere(['categoryId' => 9])
->all();

?>
<style>
  .html5-video-player a { display: none !important;}
</style>
<div class="content">
  <section class="cat-box woocommerce-box woocommerce clear">
    <div class="cat-box-title">
      <h2>Bài hát Quảng Bình Quê Ta Ơi</h2>
      <div class="stripe-line"></div>
    </div>
    <div class="cat-box-content" style="padding: 20px;border: none;">
      <!-- <iframe id="iframe-youtube" width="560" height="315" src="https://www.youtube.com/embed/1uxJg9GViVU?rel=0&cc_load_policy=1&iv_load_policy=3&fs=0&autohide=1&disablekb=1&modestbranding=1&showinfo=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
      <!-- <iframe id="iframe-youtube" width="560" height="315" src="https://www.youtube.com/embed/1uxJg9GViVU?rel=0&cc_load_policy=1&iv_load_policy=3&fs=0&autohide=1&disablekb=1&modestbranding=1&showinfo=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
      <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/1uxJg9GViVU?rel=0&showinfo=0&cc_load_policy=1&iv_load_policy=3&fs=0&autohide=1&disablekb=1&modestbranding=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <div class="clear"></div>
    </div><!-- .cat-box-content /-->
  </section>

  <section class="cat-box woocommerce-box woocommerce clear">
    <div class="cat-box-title">
      <h2>Món Ngon - Đặc sản Quảng Bình</h2>
      <div class="stripe-line"></div>
    </div>
    <div class="cat-box-content">
      <ul class="products">
        <?php foreach ($products1 as $product) { ?>
        <li class="post-<?= $product->id ?> product">
          <a href="<?= $product->createUrl() ?>" class="woocommerce-LoopProduct-link">
            <div class="product-img">
              <!-- <img width="192" height="185" src="/<?= $product->image ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image tie-appear" alt="thumb" title="thumb"> -->
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

  <section class="cat-box woocommerce-box woocommerce clear">
    <div class="cat-box-title">
      <h2>Nguyên Liệu Làm Bánh</h2>
      <div class="stripe-line"></div>
    </div>
    <div class="cat-box-content">
      <ul class="products">
        <?php foreach ($products2 as $product) { ?>
        <li class="post-<?= $product->id ?> product">
          <a href="<?= $product->createUrl() ?>" class="woocommerce-LoopProduct-link">
            <div class="product-img">
              <img width="192" height="185" src="/<?= $product->thumbnail ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image tie-appear" alt="thumb" title="thumb">
            </div>
            <h3><?= $product->name ?></h3>
            <span class="price">
              <!-- <span class="woocommerce-Price-amount amount">
                <?= number_format($product->price) ?> <span class="woocommerce-Price-currencySymbol">₫</span>
              </span> -->
            </span>
          </a>
        </li>
        <?php } ?>
      </ul><!--/.products-->
      <div class="clear"></div>
    </div><!-- .cat-box-content /-->
  </section>

<?php if(count($products3) > 0){ ?>
   <section class="cat-box woocommerce-box woocommerce clear">
    <div class="cat-box-title">
      <h2>Hải Sản</h2>
      <div class="stripe-line"></div>
    </div>
    <div class="cat-box-content" style="padding: 20px;border: none;">
      <!-- <iframe id="iframe-youtube" width="560" height="315" src="https://www.youtube.com/embed/WtJSJQIrIxk?rel=0&cc_load_policy=1&iv_load_policy=3&fs=0&autohide=1&disablekb=1&modestbranding=1&showinfo=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
      <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/WtJSJQIrIxk?rel=0&showinfo=0&cc_load_policy=1&iv_load_policy=3&fs=0&autohide=1&disablekb=1&modestbranding=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <div class="clear"></div>
    </div><!-- .cat-box-content /-->
    <div class="cat-box-content">
      <ul class="products">
        <?php foreach ($products3 as $product) { ?>
        <li class="post-<?= $product->id ?> product">
          <a href="<?= $product->createUrl() ?>" class="woocommerce-LoopProduct-link">
            <div class="product-img">
              <img width="192" height="185" src="/<?= $product->thumbnail ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image tie-appear" alt="thumb" title="thumb">
            </div>
            <h3><?= $product->name ?></h3>
            <span class="price">
              <!-- <span class="woocommerce-Price-amount amount">
                <?= number_format($product->price) ?> <span class="woocommerce-Price-currencySymbol">₫</span>
              </span> -->
            </span>
          </a>
        </li>
        <?php } ?>
      </ul><!--/.products-->
      <div class="clear"></div>
    </div><!-- .cat-box-content /-->
  </section>
<?php } ?>

<?php if(count($products4) > 0){ ?>
   <section class="cat-box woocommerce-box woocommerce clear">
    <div class="cat-box-title">
      <h2>Đặc sản Quảng Bình</h2>
      <div class="stripe-line"></div>
    </div>
    <div class="cat-box-content">
      <ul class="products">
        <?php foreach ($products4 as $product) { ?>
        <li class="post-<?= $product->id ?> product">
          <a href="<?= $product->createUrl() ?>" class="woocommerce-LoopProduct-link">
            <div class="product-img">
              <img width="192" height="185" src="/<?= $product->thumbnail ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image tie-appear" alt="thumb" title="thumb">
            </div>
            <h3><?= $product->name ?></h3>
            <span class="price">
              <!-- <span class="woocommerce-Price-amount amount">
                <?= number_format($product->price) ?> <span class="woocommerce-Price-currencySymbol">₫</span>
              </span> -->
            </span>
          </a>
        </li>
        <?php } ?>
      </ul><!--/.products-->
      <div class="clear"></div>
    </div><!-- .cat-box-content /-->
  </section>
<?php } ?>


  <section class="cat-box woocommerce-box woocommerce clear">
    <div class="cat-box-title">
      <h2>Không gian quán</h2>
      <div class="stripe-line"></div>
    </div>
    <div class="cat-box-content">
        <ul id="lightgallery" class="products">

          <?php foreach ($images as $key => $image): ?>
          <li class="post-<?= $product->id ?> product" data-src="<?= $image->url ?>" data-sub-html="">
            <a href="" class="woocommerce-LoopProduct-link">
              <div class="product-img">
                <img width="192" height="185" src="<?= $image->thumb ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image tie-appear" alt="thumb" title="thumb">
              </div>
            </a>
          </li>
          <?php endforeach ?>
        </ul>
      <!-- </div> -->
      <div class="clear"></div>
    </div><!-- .cat-box-content /-->
  </section>
</div><!-- .content /-->



