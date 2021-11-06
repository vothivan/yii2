<?php
use cms\widgets\Messages;
use common\models\Product;
use yii\helpers\Json;
use yii\helpers\Url;
?>
<section class="content-header">
	<h1>Danh sách bài viết</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" ng-controller="news">
	<div class="row">
		<div class="col-lg-12">
			<div class="box">
				<div class="box-header with-border">
					<div class="row">
						<div class="col-md-3">
							<input type="text" class="form-control" placeholder="Mã id" ng-model="pid">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" placeholder="Tên bài viết" ng-model="pname">
						</div>
						<div class="col-md-3">
							<select ng-model="categoryId" class="form-control" ng-options="c.id as c.name for c in categories"></select>
						</div>
						
					</div>
					
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary btn-sm" ng-click="list()">Tìm kiếm</button>
						</div>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>Mã</th>
									<th>Hình ảnh</th>
									<th>Tên bài viết</th>
									<th>Danh mục</th>
									<th>Trạng Thái</th>
									<th>Thuế VAT</th>
									<th>
										<button class="btn btn-xs btn-success" ng-click="add()">Thêm mới</button>
									</th>
								</tr>

								<tr ng-repeat="p in news">
									<td>{{p.id}}</td>
									<td><img ng-src="<?= Yii::$app->params['frontendBaseUrl'] ?>{{ p.image }}" width="50px" height="50px"></td>
									<td>{{p.name}}</td>
									<td>{{p.category.name}}</td>
									<td>
										<span ng-if="p.status*1 == 0" class="btn btn-success btn-xs">Hiện</span>
										<span ng-if="p.status*1 == 1" class="btn btn-danger btn-xs">Ẩn</span>
									</td>
									<td>
										<button class="btn btn-warning btn-xs" ng-click="edit(p.id)">Sửa</button>
										<button class="btn btn-danger btn-xs" ng-click="delete(p.id)">Xóa</button>
									</td>
								</tr>				
							</table>

							<div class="box-footer clearfix">
								<div class="no-margin pull-left">
									Tổng số {{ totalItem }}
								</div>
								<div class="no-margin pull-right">
									<ul class="pagination pagination-sm no-margin pull-right" ng-show="totalPage>1">
										<li><a href="javascript:;" ng-if="(activePage-1)>=1" ng-click="list(activePage-1);">«</a></li>
										<li><a href="javascript:;" ng-if="(activePage-2)>=1" ng-click="list(activePage-2);">{{(activePage-2)}}</a></li>
										<li><a href="javascript:;" ng-if="(activePage-1)>=1" ng-click="list(activePage-1);">{{(activePage-1)}}</a></li>
										<li ng-class="activePage?'active':'active'"><span>{{activePage}}</span></li>
										<li><a href="javascript:;" ng-if="(activePage+1)<=totalPage" ng-click="list(activePage+1);">{{(activePage+1)}}</a></li>
										<li><a href="javascript:;" ng-if="(activePage+2)<=totalPage" ng-click="list(activePage+2);">{{(activePage+2)}}</a></li>
										<li><a href="javascript:;" ng-if="(activePage+1)<=totalPage" ng-click="list(activePage+1);">»</a></li>
									</ul>
								</div>
							</div>
					</div> <!-- /.table-responsive -->
				</div><!-- /.box-body -->
				<div class="box-footer clearfix">

				</div>
			</div><!-- /.box -->
		</div><!-- /.col-lg-12 -->
	</div>  <!-- /.row -->
</section>  
<script type="text/ng-template" id="newsForm">
	<div class="modal-header">
		<button ng-click="cancel()" type="button" class="close" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title">{{ titleForm }} bài viết</h4>
	</div>
	<div class="modal-body">
		<div class="form-group" ng-class="errors.name?'has-error':''">
			<label>Tên bài viết(<span style="color: red">*</span>)</label>
			<input type="text" ng-model="news.name" class="form-control"/>
			<p class="help-block" ng-if="errors.name">{{errors.name[0]}}</p>
		</div>
		<div class="form-group" ng-class="errors.categoryId?'has-error':''">
			<label>Danh mục chính: </label>
			<select ng-model="news.categoryId" class="form-control" ng-options="c.id as c.name for c in categories"></select>
			<p class="help-block" ng-if="errors.categoryId">{{errors.categoryId[0]}}</p>
		</div>
		<div class="form-group">
			<label>Danh mục liên quan: </label>
			<button class="btn btn-info" ng-click="category()">{{ news.categories.length }}</button>
				<br>
		</div>
		<div class="form-group" ng-class="errors.image?'has-error':''">
			<label>Hình ảnh: </label>
			<button class="btn btn-info btn-xs" ng-click="upload()">Chọn hình ảnh</button>
			<br>
			<img ng-src="<?= Yii::$app->params['frontendBaseUrl'] ?>{{news.image}}" width="180px">
			<p class="help-block" ng-if="errors.image">{{errors.image[0]}}</p>
		</div>
		<div class="form-group" ng-class="errors.description?'has-error':''">
			<label>Mô tả ngắn(<span style="color: red">*</span>)</label>
			<textarea ng-model="news.description" cols="100%" rows="3" class="form-control"></textarea>
			<p class="help-block" ng-if="errors.description">{{errors.description[0]}}</p>
		</div>
		<div class="form-group" ng-class="errors.description2?'has-error':''">
			<label>Mô tả chi tiết</label>
			<text-angular ng-model="news.description2"></text-angular>
			<p class="help-block" ng-if="errors.description2">{{errors.description2[0]}}</p>
		</div>
		<div class="form-group" ng-class="errors.keywords?'has-error':''">
			<label>Từ khóa(<span style="color: red">*</span>)</label>
			<textarea ng-model="news.keywords" cols="100%" rows="3" class="form-control"></textarea>
			<p class="help-block" ng-if="errors.keywords">{{errors.keywords[0]}}</p>
		</div>
		<div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" ng-model="news.status" ng-true-value="1" ng-false-value="0"> Ẩn
				</label>
			</div>
		</div>
		<button class="btn btn-primary" ng-click="ok()">{{ titleForm }}</button>
	</div> <!-- /.body -->
</script><!-- /#productForm -->

<script type="text/ng-template" id="categorieForm">
	<div class="modal-header">
		<button ng-click="cancel()" type="button" class="close" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title">Danh mục</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-3" ng-repeat="c in categories">
				<div class="form-group">
					<div class="checkbox">
						<label>
							<input type="checkbox" ng-model="c.checked" ng-true-value="1" ng-false-value="0"> {{c.name}}
						</label>
					</div>
				</div>
			</div>
		</div>		
	</div> <!-- /.body -->
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary" ng-click="ok()">Xong</button>
		<button type="submit" class="btn btn-info pull-right" ng-click="cancel()">Hủy</button>
	</div>
</script><!-- /#categorieForm -->

<script>
	var categories = <?= JSON::encode($categories); ?>;
</script>