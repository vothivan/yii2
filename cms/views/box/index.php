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
							<table class="table table-hover">
								<tr>
									<th>Thứ tự</th>
									<th>Hình ảnh</th>
									<th>Tên sản phẩm</th>
									<th>Trạng Thái</th>
									<th>Thuế VAT</th>
									<th>
										<button class="btn btn-xs btn-success" ng-click="add()">Thêm mới</button>
									</th>
								</tr>

								<tr ng-repeat="p in boxs">
									<td>{{p.position}}</td>
									<td><img src="<?= Yii::$app->params['frontendBaseUrl'] ?>{{ p.product.image }}" width="50px" height="50px"></td>
									<td>{{p.product.name}}</td>
								
									<td>
										<span ng-if="p.status*1 == 1" class="btn btn-success btn-xs">Đang hiển thị</span>
										<span ng-if="p.status*1 == 0" class="btn btn-danger btn-xs">Không hiển thị</span>
									</td>
									<td>10%</td>
									<td>
										<button class="btn btn-warning btn-xs" ng-click="edit(p)">Sửa</button>
										<button class="btn btn-danger btn-xs" ng-click="remove(p)">Xóa</button>
									</td>
								</tr>				
							</table>

							<div class="box-footer clearfix">
								<div class="no-margin pull-left">Trình bày <b>1-2</b> trong số <b>2</b> mục.</div>
							</div>
					</div> <!-- /.table-responsive -->
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col-lg-12 -->
	</div>  <!-- /.row -->
</section>  
<script type="text/ng-template" id="boxForm">
	<div class="modal-header">
		<button ng-click="cancel()" type="button" class="close" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title">{{ titleForm }} sản phẩm</h4>
	</div>
	<div class="modal-body">
		<div class="form-group" ng-class="errors.productId?'has-error':''">
			<label>Mã sản phẩm(<span style="color: red">*</span>)</label>
			<input type="text" ng-model="box.productId" class="form-control"/>
			<p class="help-block" ng-if="errors.productId">{{errors.productId[0]}}</p>
		</div>
		<div class="form-group" ng-class="errors.endTime?'has-error':''">
			<label>Thời gian kết thúc(<span style="color: red">*</span>)</label>
			<div class="input-group">
				<input type="text" class="form-control"
				ng-model="box.endTime" is-open="endTimePopup.opened"
				datetime-picker="dd/MM/yyyy HH:mm" datepicker-options="dateOptions" close-text="Close"/>
				<div class="input-group-btn">
					<button type="button" class="btn btn-default" ng-click="endTime()">
						<i class="glyphicon glyphicon-calendar"></i>
					</button>
				</div>
			</div>
			<p class="help-block" ng-if="errors.endTime">{{errors.endTime[0]}}</p>
		</div>
		<div class="form-group" ng-class="errors.position?'has-error':''">
			<label>Thứ tự(<span style="color: red">*</span>)</label>
			<input type="text" ng-model="box.position" class="form-control"/>
			<p class="help-block" ng-if="errors.position">{{errors.position[0]}}</p>
		</div>
		
		<div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" ng-model="box.status" ng-true-value="1" ng-false-value="0"> Hiển thị
				</label>
			</div>
		</div>
		<button class="btn btn-primary" ng-click="ok()">{{ titleForm }}</button>
	</div> <!-- /.body -->
</script><!-- /#boxForm -->