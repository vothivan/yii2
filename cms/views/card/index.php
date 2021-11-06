<?php
use cms\widgets\Messages;
use common\models\Card;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\grid\Column;

?>
<section class="content-header">
	<h1>Danh sách thẻ điện thoại</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
	</ol>
</section>


<!-- Main content -->
<section class="content" ng-controller="card">
	<div class="row">
		<div class="col-lg-12">
			<div class="box">
				<div class="box-header with-border">
					<div class="row">
						<div class="col-md-3">
						<input type="text" class="form-control" placeholder="Nhà mạng" ng-model="ccarrier">
						</div>
						<div class="col-md-3">
						<input type="text" class="form-control" placeholder="Mệnh giá" ng-model="cprice">
						</div>
						<div class="col-md-3">					
						<input type="text" class="form-control" placeholder="Tên thẻ" ng-model="cname">
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
									<th>STT</th>
									<th>Nhà mạng</th>
									<th>Tên thẻ</th>
									<th>Mã thẻ</th>
									<th>Mệnh giá</th>
									<th>Ngày hết hạn</th>
									<th>Giá</th>
									<th>Seri</th>
									<th>
										<button class="btn btn-xs btn-success" ng-click="add()">Thêm mới</button>
									</th>
								</tr>

								<tr ng-repeat="c in cards">
									<td>{{c.id}}</td>
									<td>{{c.carrier}}</td>
									<td>{{c.name }}</td>
									<td>{{c.code}}</td>
									<td>{{c.denomination}}</td>
									<td>{{c.expiry}}</td>
									<td>{{c.price}}</td>
									<td>{{c.seri}}</td>	
									<td>
										<button class="btn btn-warning btn-xs" ng-click="edit(c.id)">Sửa</button>
										<button class="btn btn-danger btn-xs" ng-click="delete(c.id)">Xóa</button>
									</td>											
								</tr>				
							</table>

							<div class="box-footer clearfix">
								<div class="no-margin pull-left">
									 Tổng số {{ totalItem }} sản phẩm
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


<script type="text/ng-template" id="cardForm">
	
	<div class="modal-body">
	<div class="modal-header">
		<button ng-click="cancel()" type="button" class="close" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title">{{ titleForm }} thẻ điện thoại</h4>
	</div>
		<div class="form-group" ng-class="errors.carrier?'has-error':''">
			<label>Nhà mạng (<span style="color: red">*</span>)</label>
			<input type="text" ng-model="card.carrier" class="form-control"/>
			<p class="help-block" ng-if="errors.carrier">{{errors.carrier[0]}}</p>
		</div>

		<div class="form-group" ng-class="errors.name?'has-error':''">
			<label>Tên thẻ </label>
			<input type="text" ng-model="card.name" class="form-control"/>
			<p class="help-block" ng-if="errors.name">{{errors.name[0]}}</p>
		</div>

		<div class="form-group" ng-class="errors.code?'has-error':''">
			<label>Mã thẻ (<span style="color: red">*</span>)</label>
			<input type="text" ng-model="card.code" class="form-control"/>
			<p class="help-block" ng-if="errors.code">{{errors.code[0]}}</p>
		</div>

		<div class="form-group" ng-class="errors.denomination?'has-error':''">
			<label>Mệnh giá</label>
			<input type="text" ng-model="card.denomination" class="form-control"/>
			<p class="help-block" ng-if="errors.denomination">{{errors.denomination[0]}}</p>
		</div>

		<div class="form-group" ng-class="errors.expiry?'has-error':''">
			<label>Ngày hết hạn (<span style="color: red">*</span>)</label>
			<input type="text" ng-model="card.expiry" class="form-control"/>
			<p class="help-block" ng-if="errors.expiry">{{errors.expiry[0]}}</p>
		</div>

		<div class="form-group" ng-class="errors.price?'has-error':''">
			<label>Giá</label>
			<input type="text" ng-model="card.price" class="form-control"/>
			<p class="help-block" ng-if="errors.price">{{errors.price[0]}}</p>
		</div>

		<div class="form-group" ng-class="errors.seri?'has-error':''">
			<label>Số seri (<span style="color: red">*</span>)</label>
			<input type="text" ng-model="card.seri" class="form-control"/>
			<p class="help-block" ng-if="errors.seri">{{errors.seri[0]}}</p>
		</div>
		<div class="modal-footer">
		<button type="submit" class="btn btn-primary" ng-click="ok()">{{ titleForm }}</button>
		
	</div>
</script>

<!-- <script type="text/ng-template" id="categorieForm">
	<div class="modal-header">
		<button ng-click="cancel()" type="button" class="close" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title">Danh mục</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-3" ng-repeat="c in cards">
				<div class="form-group">
					<div class="checkbox">
						<label>
							<input type="checkbox" ng-model="c.checked" ng-true-value="1" ng-false-value="0"> {{c.name}}
						</label>
					</div>
				</div>
			</div>
		</div>		
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary" ng-click="ok()">Xong</button>
		<button type="submit" class="btn btn-info pull-right" ng-click="cancel()">Hủy</button>
	</div>
</script> -->



