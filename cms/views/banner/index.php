<?php
use cms\widgets\Messages;
use common\models\Product;
use yii\helpers\Json;
use yii\helpers\Url;
?>
<section class="content-header">
	<h1>Danh sách sản phẩm</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" ng-controller="box">
	<div class="row">
		<div class="col-lg-12">
			<div class="box">
				<div class="box-header with-border">
					<!-- <h3 class="box-title">Danh sách quản trị viên</h3> -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive no-padding">
						<style>
						img{cursor: grab;}
					</style>
					<table class="table table-hover">
						<tr>
							<td rowspan="2">
								<img src="<?= Yii::$app->params['frontendBaseUrl'].$model[0]->image ?>" width="100%" ng-click='changeBanner(<?= Json::encode($model[0]); ?>)'>
							</td>
							<td colspan="4">
								<img src="<?= Yii::$app->params['frontendBaseUrl'].$model[1]->image ?>" width="100%" ng-click='changeBanner(<?= Json::encode($model[1]); ?>)'>
							</td>
							<td rowspan="2">
								<img src="<?= Yii::$app->params['frontendBaseUrl'].$model[2]->image ?>" width="100%" ng-click='changeBanner(<?= Json::encode($model[2]); ?>)'>
							</td>
						</tr>
						<tr>
							<td>
								<img src="<?= Yii::$app->params['frontendBaseUrl'].$model[3]->image ?>" width="100%" ng-click='changeBanner(<?= Json::encode($model[3]); ?>)'>
							</td>
							<td>
								<img src="<?= Yii::$app->params['frontendBaseUrl'].$model[4]->image ?>" width="100%" ng-click='changeBanner(<?= Json::encode($model[4]); ?>)'>
							</td>
						</tr>				
					</table>
				</div> <!-- /.table-responsive -->
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col-lg-12 -->
</div>  <!-- /.row -->
</section>  
<script type="text/ng-template" id="bannerForm">
	<div class="modal-header">
		<button ng-click="cancel()" type="button" class="close" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title">{{ titleForm }} sản phẩm</h4>
	</div>
	<div class="modal-body">
		<div class="form-group" ng-class="errors.url?'has-error':''">
			<label>Url(<span style="color: red">*</span>)</label>
			<input type="text" ng-model="banner.url" class="form-control"/>
			<p class="help-block" ng-if="errors.url">{{errors.url[0]}}</p>
		</div>
		<div class="form-group" ng-class="errors.image?'has-error':''">
			<label>Hình ảnh: </label>
			<button class="btn btn-info btn-xs" ng-click="upload()">Chọn hình ảnh</button>
			<br>
			<img ng-src="<?= Yii::$app->params['frontendBaseUrl'] ?>{{banner.image}}" width="180px">
			<p class="help-block" ng-if="errors.image">{{errors.image[0]}}</p>
		</div>
		<button class="btn btn-primary" ng-click="ok()">{{ titleForm }}</button>
	</div> <!-- /.body -->
</script><!-- /#bannerForm -->