<?php
use yii\helpers\Url;
?>
<style>
.text-white{
	color: #fff;
}
</style>
<header class="main-header">
	<div href="<?= Url::home() ?>" class="logo">
		<span class="logo-mini">
			<a class="text-white" href="<?= Yii::$app->params['frontendBaseUrl'] ?>"><b><i class="fa fa-fw fa-home"></i></b></a>| <a class="text-white" href="/"><b><i class="fa fa-dashboard"></i></b></a>
		</span>
		<span class="logo-lg">
			<a class="text-white" href="<?= Yii::$app->params['frontendBaseUrl'] ?>"><b><i class="fa fa-fw fa-home"></i></b></a>| <a class="text-white" href="/"><b><i class="fa fa-dashboard"></i></b></a>
		</span>
	</div>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-user"></i> <?= Yii::$app->user->identity->name ?>
					</a>
				</li>
			</ul>
		</div>
	</nav>
</header>
<aside class="main-sidebar">
	<div class="slimScrollDiv">
		<section class="sidebar" style="overflow: hidden;">
			<?php 

			$auths = [];
			$auths['order'] 	= ['label' => 'Đơn hàng', 'icon' => 'fa fa-dashboard', 'url' => ['order/index']];

			$auths['category'] 	= ['label' => 'Danh mục', 'icon' => 'fa fa-dashboard', 'url' => ['category/index']];
			$auths['product'] 	= ['label' => 'Sản phẩm', 'icon' => 'fa fa-dashboard', 'url' => ['product/index']];
			$auths['customer'] 	= ['label' => 'Khách hàng', 'icon' => 'fa fa-dashboard', 'url' => ['customer/index']];
			$auths['staff'] 	= ['label' => 'Nhân viên', 'icon' => 'fa fa-dashboard', 'url' => ['staff/index']];
			$auths['report'] 	= [
				'label' => 'Báo cáo',
				'icon' => 'fa fa-gear',
				'url' => '#',
				'items' => [
					['label' => 'Báo cáo đơn hàng', 'icon' => 'fa fa-circle-o', 'url' => ['report/index']],
				],
			];
			$auths['news'] 	= [
				'label' => 'Tin tức',
				'icon' => 'fa fa-gear',
				'url' => '#',
				'items' => [
					['label' => 'Bài viết', 'icon' => 'fa fa-circle-o', 'url' => ['news/index']],
					['label' => 'Danh mục', 'icon' => 'fa fa-circle-o', 'url' => ['category-news/index']],
				],
			];
			$auths['infoconfig']= ['label' => 'Cài đặt', 'icon' => 'fa fa-dashboard', 'url' => ['infoconfig/index']];
			$auths['banner'] 		= ['label' => 'Banner', 'icon' => 'fa fa-dashboard', 'url' => ['banner/index']];
			$auths['box'] 		= ['label' => 'Box Khuyến mại', 'icon' => 'fa fa-dashboard', 'url' => ['box/index']];
			$auths['restaurant-view'] 		= ['label' => 'Không gian quán', 'icon' => 'fa fa-dashboard', 'url' => ['restaurant-view/index']];
			
			$user = Yii::$app->user->identity;
			$listAuths = $user->auths;
			$arrAuths = json_decode($listAuths);

			$menu = [];
			$menu[] = ['label' => 'Tổng quan', 'icon' => 'fa fa-dashboard', 'url' => ['site/index']];
			$menu[] = ['label' => 'Thẻ điện thoại', 'icon' => 'fa fa-dashboard', 'url' => ['card/index']];
			if(is_array($arrAuths) && count($arrAuths) > 0){
				foreach ($arrAuths as $k => $v) {
					if (isset($auths[$v])) {
						$menu[] = $auths[$v];
					}
				}
			}
			?>
			<?= 
			\dmstr\widgets\Menu::widget(
				[
					'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
					'items' => $menu,
				]
				) ;
				?>
			</section><!-- /.sidebar -->
			<!-- <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 102px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 331.432px;"></div> -->
			<!-- <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div> -->
		</div>
	</aside>
