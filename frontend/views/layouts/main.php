<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\Navigation;
use frontend\widgets\Footer;
use frontend\widgets\Modal;
use frontend\assets\AppAsset;
use yii\helpers\Json;
use common\models\News;

$newss = News::find()
->select('id, categories, name, keywords, image, status, rating, view, createTime, categoryId, staffId')
->limit(5)
->andWhere(['status' => 0])
->orderBy('id desc')
->all();
$hot = $newss[0];

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#" class=" js no-touch csstransforms csstransforms3d csstransitions svg">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="fb:app_id" content="229798828461329"/>
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="<?= Url::base() ?>/assets2/images/ico.ico" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php
    if (isset($this->params['og'])) {
        foreach ($this->params['og'] as $key => $value) {
            echo '<meta property="og:' . $key . '" content="' . $value . '"/>';
        }
        if (isset($this->params['og']['url'])) {
            echo '<link rel="canonical" href="' . $this->params['og']['url'] . '"/>';
        }
    }
    if (isset($this->params['noindex'])) {
        echo '<meta name="robots" content="noindex" />';
    }
    ?>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-176922835-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-176922835-1');
  </script>


  <style>
  body{
  	background-color: #152836
  }
  .home .demo-gallery {
  	padding-bottom: 80px;
  }
  .product:nth-child(3n-2) {
  	clear: both!important;
  }

  .product:nth-child(3n-0) {
  	margin-right: 0!important;
  }
  @media only screen and (min-width: 1024px) {
  	.wp-post-image{
  		width: 190px;
  		height: 185px;
  	}

  	.lg-backdrop{
  		background-color: rgba(0,0,0,0.7);
  	}
  	.lg-outer{
  		top: 50%;
  		left: 50%;
  		transform: translate(-50%, -50%);
  		height: 80%;
  		width: 80%;
  		border: 1px solid #fff;
  	}
  	.lg-img-wrap {
  		background: rgba(0,0,0,0.7);
  	}
  }
  @media only screen and (min-width: 768px) {
  	.wp-post-image{
  		width: 190px;
  		height: 160px;
  	}
  }

</style>

</head>
<body id="top" class="home page-template-default page single-product lazy-enabled">
    <div class="wrapper-outer">
        <div class="background-cover"></div>
        <aside id="slide-out">
            <div class="search-mobile">
                <form method="get" id="searchform-mobile" action="/">
                    <button class="search-button" type="submit" value="Search"><i class="fa fa-search"></i></button>    
                    <input type="text" id="s-mobile" name="s" title="Search" value="Search" onfocus="if (this.value == &#39;Search&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;Search&#39;;}">
                </form>
            </div><!-- .search-mobile /-->
            <div class="social-icons">
                <a class="ttip-none" title="Rss" href="https://banhlocphuongthu.com/feed" target="_blank"><i class="fa fa-rss"></i></a>
            </div>
            <div id="mobile-menu">
            </div>
        </aside><!-- #slide-out /-->
        <div id="wrapper" class="boxed">
            <div class="inner-wrapper">
                <header id="theme-header" class="theme-header full-logo center-logo">
                    <div class="header-content">
                        <a id="slide-out-open" class="slide-out-open" href="#"><span></span></a>
                        <div class="logo" style=" margin-top:15px; margin-bottom:15px;">
                            <h1>
                                <a title="" href="https://banhlocphuongthu.com/">
                                    <!-- <img src="/assets2/images/banner2.png" alt=""><strong>..</strong> -->
                                    <img src="/assets2/images/bn.png" alt=""><strong>..</strong>
                                    <!-- <img src="/uploads/banner.jpg" alt=""><strong>..</strong> -->

                                </a>
                            </h1>           
                        </div><!-- .logo /-->
                        <div class="clear"></div>
                    </div>  
                    <nav id="main-nav" class="fixed-enabled">
                        <div class="container">
                            <div class="main-menu">
                                <ul id="menu-head" class="menu">
                                    <li id="menu-item-156" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-156"><a href="/">Trang chủ</a></li>
                                    <li id="menu-item-526" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-526"><a href="/tim-kiem?cid=6">Menu bánh</a></li>
                                    <li id="menu-item-527" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-527"><a href="/gioi-thieu-n3.html">Giới thiệu</a></li>
                                    <li id="menu-item-527" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-527"><a href="/tim-kiem?cid=1">Nguyên liệu làm bánh</a></li>
                                    <li id="menu-item-527" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-527"><a href="/huong-dan-dat-hang-n7.html">Hướng dẫn đặt hàng</a></li>
                                    <li id="menu-item-274" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-274"><a href="/tin-tuc">Tin tức</a></li>
                                    <li id="menu-item-278" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-278"><a href="/tuyen-dung-n6.html">Tuyển dụng</a></li>
                                </ul>
                            </div>                                      
                            <a href="https://banhlocphuongthu.com/?tierand=1" class="random-article ttip" original-title="Random Article"><i class="fa fa-random"></i></a>
                        </div>
                    </nav><!-- .main-nav /-->
                </header><!-- #header /-->

                <div class="clear"></div>
                <div id="breaking-news" class="breaking-news">
                    <span class="breaking-news-title"><i class="fa fa-bolt"></i> <span>Tin HOT</span></span>
                    <ul class="innerFade" style="position: relative; height: 32px;">
                        <li><a href="<?= $hot->createUrl() ?>" title=""><?= $hot->name ?></a></li>
                    </ul>
                </div> <!-- .breaking-news -->

                <div id="main-content" class="container">
                    <div class="livechat items-center">
                        <a href="/huong-dan-dat-hang-n7.html">Click Ship hàng</a>
                        <a href="tel:0948987247">
                            <span class="phone"></span>
                            <span class="hotline">0948.987.247</span>
                        </a>
                    </div>
                    <?= $content ?>

                    <aside id="sidebar" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
                        <div class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static;">
                            <div id="text-2" class="widget widget_text">
                                <div class="widget-top">
                                    <h4>Hỗ trợ trực tuyến</h4>
                                    <div class="stripe-line">

                                    </div>
                                </div>
                                <div class="widget-container">          
                                    <div class="textwidget"><b>Bánh Lọc Phương Thu:</b> 701C tòa nhà Hòa Phát, 99 Tân Mai, Hoàng Mai, Hà Nội.<br>
                                        <font color="red" size="3">
                                            Xem chỉ dẫn đường đi 
                                            <b>
                                                <a href="https://www.google.com/maps/place/99+Ph%E1%BB%91+T%C3%A2n+Mai,+T%C3%A2n+Mai,+Ho%C3%A0ng+Mai,+H%C3%A0+N%E1%BB%99i,+Vi%E1%BB%87t+Nam/@20.9837363,105.8476928,19z/data=!3m1!4b1!4m5!3m4!1s0x3135ac41c2ce5063:0x9ebb78599581ad92!8m2!3d20.983735!4d105.84824?hl=vi-VN" title="" alt="">TẠI ĐÂY</a>
                                            </b>
                                        </font>
                                        <center>
                                            ---------------------***-----------------------<br>
                                            <div class="info" style="text-align: left;">
                                                <b>
                                                    <font color="red" size="4">Mrs Phương: 0948.987.247</font> <br>
                                                    <font color="red" size="4">Mrs Thu: 0912.771.436</font>
                                                </b> 
                                            </div>
                                        </center>
                                        <p><b>Thời gian mở cứa hàng:</b></p>
                                        <p>* <b>Đặt hàng:</b> Từ 7h00 đến 21h00</p>
                                        <p>* <b>Giao hàng:</b> Từ 9h đến 20h</p>
                                    </div>
                                </div>
                            </div><!-- .widget /-->
                 
                            
                             <div id="text-3" class="widget widget_text">
                                 <div class="widget-top">
                                    <h4>Hướng dẫn hấp Bánh Bột Lọc</h4>
                                    <div class="stripe-line">

                                    </div>
                                </div>
                                <div class="widget-container">          
                                    <div class="textwidget">
                                      <!-- <video width="100%" height="240" controls poster="/uploads/thumbnail/20200901005920.jpg">
                                        <source src="/assets2/huong-dan-hap-banh.mp4" type="video/mp4">
                                          Video không hỗ trợ cho trình duyệt này!
                                        </video> -->
                                        <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/o2CJCWkSyTM?rel=0&cc_load_policy=1&iv_load_policy=3&fs=0&autohide=1&disablekb=1&modestbranding=1&showinfo=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->

                                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/o2CJCWkSyTM?rel=0&showinfo=0&cc_load_policy=1&iv_load_policy=3&fs=0&autohide=1&disablekb=1&modestbranding=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      
                                    </div>
                                </div>
                            </div>
                            <!-- .widget /-->
                            
                            
                            <div id="facebooklikebox-2" class="widget widget_FacebookLikeBox">
                            	<div class="widget-top">
                            		<h4> </h4>
                            		<div class="stripe-line"></div>
                            	</div>
                            	<div class="widget-container">
                            		
                            		<div class="fb-page" 
                            		data-href="https://www.facebook.com/banh-loc-phuong-thu-105470414626651/" 
                            		data-tabs="false" 
                            		data-width="292px" 
                            		data-height="180px"
                            		data-small-header="false" 
                            		data-adapt-container-width="true" 
                            		data-hide-cover="false" 
                            		data-show-facepile="true">
                            		<blockquote cite="https://www.facebook.com/banh-loc-phuong-thu-105470414626651/" class="fb-xfbml-parse-ignore">
                            			<a href="https://www.facebook.com/banh-loc-phuong-thu-105470414626651/">BÁNH LỌC Phuong Thu _ Món ngon Quảng Bình tại Hà Nội</a>
                            		</blockquote>
                            	</div>
                            </div>
                            </div><!-- .widget /-->
                            <div id="categort-posts-widget-3" class="widget categort-posts">
                                <div class="widget-top"><h4>Tin tức</h4><div class="stripe-line"></div></div>
                                <div class="widget-container">              
                                    <ul>
                                        <?php foreach ($newss as $h => $news): ?>
                                            <li>
                                                <div class="post-thumbnail tie-appear">
                                                    <a href="<?= $news->createUrl() ?>" rel="bookmark">
                                                        <img width="110" height="75" src="/<?= $news->image ?>" class="attachment-tie-small size-tie-small wp-post-image tie-appear" alt="">
                                                        <span class="fa overlay-icon"></span>
                                                    </a>
                                                </div><!-- post-thumbnail /-->
                                                <h3>
                                                    <a href="<?= $news->createUrl() ?>"><?= $news->name ?></a>
                                                </h3>
                                                <span class="tie-date"><i class="fa fa-clock-o"></i><?= date("d/m/Y", $news->createTime) ?></span>      
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                            </div><!-- .widget /--> 
                        </div><!-- .theiaStickySidebar /-->
                    </aside><!-- #sidebar /-->  
                    <div class="clear"></div>
                </div><!-- .container /-->
                <?= Footer::widget() ?>

            </div><!-- .inner-Wrapper -->
        </div><!-- #Wrapper -->
    </div><!-- .Wrapper-outer -->
    <?= Modal::widget() ?>


    <script>
        var baseUrl = '<?= Url::base() ?>';
    </script>
    <?php $this->endBody(); ?>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var tie = {"mobile_menu_active":"true","mobile_menu_top":"","lightbox_all":"true","lightbox_gallery":"true","woocommerce_lightbox":"yes","lightbox_skin":"dark","lightbox_thumb":"vertical","lightbox_arrows":"","sticky_sidebar":"1","is_singular":"1","SmothScroll":"true","reading_indicator":"","lang_no_results":"No Results","lang_results_found":"Results Found"};
        /* ]]> */
    </script>
    <script>
    	$(document).ready(function () {
    		<?= Yii::$app->controller->clientScript ?>;

    		$("#iframe-youtube").on("load", function() {
    			let head = $("#iframe-youtube").contents().find("head");
    			let css = '<style>.html5-video-player a { display: none !important;}</style>';
    			$(head).append(css);
    		});
    	});

    	// window.onload = function() {
    	// 	let myiFrame = document.getElementById("iframe-youtube");
    	// 	let doc = myiFrame.contentDocument;
    	// 	doc.body.innerHTML = doc.body.innerHTML + '<style>.html5-video-player a { display: none !important;}</style>';
    	// }
    </script>

    <script type="text/javascript">
    	$(document).ready(function(){
    		$('#lightgallery').lightGallery();
    	});
    </script>

    <script>
    CloudZoom.quickStart();
    // $('.nstSlider').nstSlider({
    //     "rounding": {
    //     "1000000" : "10000000"
    //     },
    //     "left_grip_selector": ".leftGrip",
    //     "right_grip_selector": ".rightGrip",
    //     "value_bar_selector": ".bar",
    //     "value_changed_callback": function(cause, leftValue, rightValue) {
    //     $('.leftLabel').val(leftValue);
    //     $('.rightLabel').val(rightValue);
    //     }
    // });
    </script>

    <script>
        localStorage.setItem('__fb_chat_plugin', '{"path":2,"chatState":1,"visibility":"hidden","showUpgradePrompt":"not_shown"}');
    </script>
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v8.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v8.0&appId=229798828461329&autoLogAppEvents=1" nonce="CvBz24GB"></script>

<!-- <script>
	window.fbAsyncInit = function() {
		FB.init({
			xfbml            : true,
			version          : 'v8.0'
		});
	};
	(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src =   "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=229798828461329&autoLogAppEvents=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> -->

<div class="fb-customerchat"
attribution=setup_tool
page_id="105470414626651"
logged_in_greeting="Quán Bánh Lọc Phương Thu xin chào quý khách!"
logged_out_greeting="Quán Bánh Lọc Phương Thu xin chào quý khách!"
greeting_dialog_display="hide"
>
</div>

</body>
</html>
<?php $this->endPage(); ?>