<?php
use yii\helpers\Url;
use common\models\ProductSearch;
use common\models\Keyword;
use common\components\ImageClient;
use frontend\widgets\HomeProduct;

?>

<div class="container container-v2" ng-controller="search" ng-cloak>
	<div class="l-content">
		<div class="clearfix">
			<div class="l-main">
				<div class="c-browse-control">
					<div class="c-browse-control__title">
							</div>
							<div class="c-browse-control__order">
								<label>Sắp xếp theo</label>
						
							</div>
						</div><!-- c-browse-control -->
						<div class="c-filter-mobile">
							<ul class="clearfix">
								<li><a href="#filter-category-id"><i class="fa fa-list-ul"></i>Danh mục</a></li>
								<li><a href="#filter-properties-id"><i class="fa fa-filter"></i>Lọc</a></li>
							</ul>
						</div><!-- c-filter-mobile -->
						<div class="c-product-grid c-product-hover">
							<ul class="clearfix">
				
							</ul>
						</div><!-- c-product-grid -->
						<div class="b-page">

						</div><!-- b-page -->
					</div><!-- l-main -->
					<div class="l-sidebar">
						<div class="c-sidebar-ovelay js-sidebar-ovelay"></div>
							<div class="c-sidebar-filter" id="filter-category-id">
								<span class="c-sidebar-close js-sidebar-close"><i class="fa fa-long-arrow-left"></i></span>
				
								<div class="c-whitebox">
									<div class="c-whitebox__title">
	
											<a class="c-whitebox__title__name" href="#">
												Danh mục
											</a>
									
						            </div>
									<div class="c-whitebox__content">
										<div class="c-sidebar-menu">
											<ul>
										
											</ul>
										</div><!-- c-sidebar-menu -->
									</div>
								</div><!-- c-whitebox -->
							</div><!-- c-sidebar-filter -->
							<div class="c-sidebar-filter" id="filter-properties-id">
								<span class="c-sidebar-close js-sidebar-close"><i class="fa fa-long-arrow-left"></i></span>
								<div class="c-whitebox">
									<div class="c-whitebox__title">
										<div class="c-whitebox__title__name"><i class="fa fa-filter"></i>Lựa chọn tìm kiếm</div>
									</div>
									<div class="c-whitebox__content">
			
										<div class="c-widget">
											<div class="c-widget__title">
												<div class="c-widget__title__name">Khoảng giá</div>
												<i class="c-widget__close fa fa-angle-down"></i>
											</div>
											<div class="c-widget__content">
											
											</div><!-- c-widget__content -->
										</div><!-- c-widget -->
									</div><!-- c-whitebox__content -->
								</div><!-- c-whitebox -->
							</div><!-- c-sidebar-filter -->
						</div><!-- l-sidebar -->
					</div><!-- clearfix -->
				</div><!-- l-content -->
			</div><!-- container -->