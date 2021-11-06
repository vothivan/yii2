<section class="content-header">
	<h1>
		Đơn hàng
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	</ol>
</section>
<section class="content" ng-controller="order">
	<div class="box box-primary">
		<div class="box-header with-border">
			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-xs-3">
							<input type="text" class="form-control" placeholder="Mã đơn hàng" ng-model="oid">
						</div>
						<div class="col-xs-3">
							<input type="text" class="form-control" placeholder="Họ tên hoặc Số điện thoại" ng-model="name">
						</div>
						<div class="col-xs-3">
							<button class="btn btn-primary btn-sm" ng-click="list()">Tìm kiếm</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12" >
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li ng-click="status = -1;list();" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><b>Tất cả[{{ count[0] }}]</b></a></li>
							<li ng-click="status = 0;list();" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><b class="text-yellow">Chờ duyệt({{ count[1] }})</b></a></li>
							<li ng-click="status = 1;list();" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b class="text-aqua">Đã duyệt({{ count[2] }})</b></a></li>
							<li ng-click="status = 2;list();" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b class="text-light-blue">Đang giao hàng({{ count[3] }})</b></a></li>
							<li ng-click="status = 3;list();" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b class="text-green">Hoàn thành({{ count[4] }})</b></a></li>
							<li ng-click="status = 4;list();" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b class="text-red">Hủy({{ count[5] }})</b></a></li>
							<!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
							<li class="pull-right"><a href="#">Tổng tất cả <b>{{ count.all }}</b> đơn hàng</a></li>
						</ul>
					</div>
					<!-- <div class="box box-default box-solid" ng-repeat="order in orders" ng-class="getStatusClass(order.status)"> -->
					<div class="box box-solid" ng-repeat="order in orders" ng-class="getStatusClass(order.status)">
						<div class="box-header with-border">
							<h3 class="box-title">Mã đơn hàng: {{order.id}} | {{order.totalPrice*1 + 30000 | number}} vnđ | {{order.contactName}} | {{order.contactPhone}} </h3>
							<!-- <b class="text-yellow">[Chờ duyệt]</b> -->
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" ng-click="btnShow(order.id)">
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" id="show-{{order.id}}">
							<table class="table table-bordered">
								<tr>
									<td>Thông tin khách hàng</td>
									<td>Sản phẩm</td>
									<td>Thao tác</td>
								</tr>
								<tr>
									<td style="vertical-align: top">
										<p>Họ tên: {{order.contactName}}</p>
										<p>Số điện thoại: {{order.contactPhone}}</p>
										<p>Email: {{order.contactEmail}}</p>
										<p>Địa chỉ: {{order.address}}</p>
										<p>Ghi chú: {{order.note}}</p>
									</td>
									<td>
										<table class="table">
											<tr ng-repeat="product in order.products">
												<td>
													<p><img src="<?= Yii::$app->params['frontendBaseUrl'] ?>{{product.productData.image}}" width="40px" /></p>
													<p>Tên sản phẩm: {{product.name}}</p>
													<p>Giá: {{product.price | number}} vnđ</p>
												</td>
												<td>
													<p>x{{product.quantity}}</p>
													<p>= {{product.price * product.quantity | number}}vnđ</p>
												</td>
											</tr>
										</table>
									</td>
									<td style="vertical-align: top">
										<p ng-if="order.createTime > 0">Đặt hàng lúc: {{order.createTime*1000 | date:"dd/MM/yyyy HH:mm:ss"}}</p>
										<p ng-if="order.confirmTime > 0">Xác nhận lúc: {{order.confirmTime*1000 | date:"dd/MM/yyyy HH:mm:ss"}}</p>
										<p ng-if="order.doneTime > 0">Hoàn thành lúc: {{order.doneTime*1000 | date:"dd/MM/yyyy HH:mm:ss"}}</p>
										<p ng-if="order.cancelTime > 0">Hủy lúc: {{order.cancelTime*1000 | date:"dd/MM/yyyy HH:mm:ss"}}</p>
										<p style="border-bottom: 1px solid #696969;"></p>
										<p>Phí vận chuyển: {{30000 | number}} vnđ</p>
										<p>Tiền hàng: {{order.totalPrice | number}} vnđ</p>
										<p>Tổng tiền: {{order.totalPrice*1 + 30000 | number}} vnđ</p>
										<p>
											Trạng thái :
											<span class="label label-warning" ng-if="order.status==0">Chờ xác nhận</span>
											<span class="label label-info" ng-if="order.status==1">Đã xác nhận</span>
											<span class="label label-primary" ng-if="order.status==2">Đang giao hàng</span>
											<span class="label label-success" ng-if="order.status==3">Đã giao hàng</span>
											<span class="label label-danger" ng-if="order.status==4">Đã hủy</span>
										</p>
										<button class="btn btn-info btn-sm" ng-show="order.status==0" ng-click="changestatus(order.id,1)">Xác nhận</button>
										<button class="btn btn-primary btn-sm" ng-show="order.status==1" ng-click="changestatus(order.id,2)">Giao hàng</button>
										<button class="btn btn-success btn-sm" ng-show="order.status==2" ng-click="changestatus(order.id,3)">Hoàn thành</button>
										<button class="btn btn-danger btn-sm" ng-show="order.status!=4 && order.status!=3" ng-click="changestatus(order.id,4)">Hủy</button>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div><!-- /.row --> 
		</div>

		<div class="box-footer clearfix">
			<div class="no-margin pull-left">
				Tổng số {{ totalItem }} đơn hàng
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
	</div>
</section>
