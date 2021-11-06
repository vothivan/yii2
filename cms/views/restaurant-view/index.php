<?php
use cms\widgets\Messages;
use common\models\Product;
use yii\helpers\Json;
use yii\helpers\Url;
?>

<style>
.image-group{
	display: inline-block;
}
.image-item{
	display: block;
	width: 140px;
	float: left;
	margin-right: 10px;
	margin-bottom: 10px;
	overflow: hidden;
}
.image-name{
	text-align: center;
	font-weight: 100;
	padding: 5px 0 0 0;
	color: #6f6a65;
}
.image-item .item{
	width: 140px;
	height: 140px;
	border: 1px dashed #00c0ef;
	position: relative;
	cursor: all-scroll;
	display: flex;
	align-items: center;
	overflow: hidden;
}
.image-item .item:hover .item-tool{
	display: block;
}
.image-item .item .item-tool{
	display: none;
	position: absolute;
	color: #eeeeee;
	bottom: 0;
	text-align: center;
	width: 100%;
	background: rgba(0,0,0,0.4);
	padding: 5px 10px;
	cursor: pointer;
}
.image-item .item .item-tool .item-action{
	font-size: 16px;
	text-align: center;
	display: block;
	width: 50%;
	float: left;
	transition: transform .2s;
}
.image-item .item .item-tool .item-action:hover{
	-ms-transform: scale(1.2);
	-webkit-transform: scale(1.2);
	transform: scale(1.2);
}
.image-item .item .item-img{
	width: 100%;
	vertical-align: middle;
}
.btn-add-image{
	color: #00c0ef;
	font-size: 70px;
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translate(-50%, -50%);
	cursor: pointer;
}
</style>
<script>
	var images = <?= $images ?>;
</script>
<section class="content-header">
	<h1>Hình ảnh không gian quán</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" ng-controller="restaurant-view">
	<div class="row">
		<div class="col-lg-12">
			<div class="box">
				<div class="box-header with-border">

					
				</div><!-- /.box-header -->

				<div class="box-body">
					<div class="form-group">
						<div class="image-group">
							<span ng-sortable>
								<div class="image-item" ng-repeat="(k,image) in images">
									<div class="item">
										<img class="item-img" ng-src="{{image.thumb}}"/>
										<div class="item-tool">
											<!-- <span class="item-action" ng-click="crop(image.image)">
												<i class="fa fa-crop"></i>
											</span> -->
											<span class="item-action" ng-disabled="check" ng-click="removeBanner(k)">
												<i class="fa fa-trash"></i>
											</span>
										</div>
									</div>
									<div class="image-name">hình ảnh {{(k+1)}}</div>
								</div>
							</span>
							<div class="image-item">
								<div class="item" ng-click="inputDataImage()">
									<i class="fa fa-plus-circle btn-add-image"></i>
								</div>
							</div>
						</div>
						<p class="help-block" ng-if="errors.image">{{errors.image[0]}}</p>
						<p class="help-block" ng-if="newImage.error">{{newImage.error}}</p>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer clearfix">
					<button class="btn btn-sm btn-primary" ng-click="update();">Cập nhật</button>
				</div>
			</div><!-- /.box -->
		</div><!-- /.col-lg-12 -->
	</div>  <!-- /.row -->
</section>  