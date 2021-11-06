<?php
use yii\helpers\Url;
use common\models\ProductSearch;
use common\models\Keyword;
use common\components\ImageClient;
use frontend\widgets\UserSidebar;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$status = [
	0 => 'label-default',
	1 => 'label-default',
	2 => 'label-default',
	3 => 'label-warning',
	4 => 'label-info',
	5 => 'label-success',
	6 => 'label-info',
	7 => 'label-info',
	8 => 'label-danger',
];

?>
<div class="container container-v2" ng-controller="user_order">
	<div class="l-content">
		<ol class="breadcrumb">
			<li><a href="#">Trang chủ</a></li>
			<li class="active">Lịch sử đơn hàng</li>
		</ol>
		<div class="clearfix">
			<div class="l-main is-normal">
				<div class="c-whitebox">
					<div class="c-whitebox__title">
						<div class="c-whitebox__title__name">Lịch sử đơn hàng</div>
					</div>
					<div class="c-whitebox__content">
						<div class="c-whitebox__inner">
							<div class="b-form c-bill-filter">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li ng-click="status = -1;list();" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><b>Tất cả[{{ count[0] }}]</b></a></li>
										<li ng-click="status = 0;list();" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><b class="text-yellow">Chờ duyệt({{ count[1] }})</b></a></li>
										<li ng-click="status = 1;list();" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b class="text-aqua">Đã duyệt({{ count[2] }})</b></a></li>
										<li ng-click="status = 2;list();" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b class="text-light-blue">Đang giao hàng({{ count[3] }})</b></a></li>
										<li ng-click="status = 3;list();" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b class="text-green">Đã giao hàng({{ count[4] }})</b></a></li>
										<li ng-click="status = 4;list();" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b class="text-red">Hủy({{ count[5] }})</b></a></li>
									</ul>
								</div>
							</div><!-- c-bill-filter -->
							<div class="table-responsive c-table-bill">
								<div class="box box-solid" ng-repeat="order in orders" ng-class="getStatusClass(order.status)">
									<div class="box-body"  id="show-{{order.id}}">
										<table class="table table-bordered">
											<tr>
												<td style="width: 30%">Thông tin nhận hàng</td>
												<td style="width: 40%">Sản phẩm</td>
												<td style="width: 30%">Theo dõi</td>
											</tr>
											<tr>
												<td>
													<p>Họ tên: {{order.contactName}}</p>
													<p>Số điện thoại: {{order.contactPhone}}</p>
													<p>Email: {{order.contactEmail}}</p>
													<p>Địa chỉ: {{order.address}}</p>
													<p>Ghi chú: {{order.note}}</p>
												</td>
												<td>
													<table class="table table-bordered">
														<tr ng-repeat="product in order.products">
															<td>
																<p><img src="<?= Url::base() ?>{{product.productData.image}}" width="40px" /> <b>{{product.name}}</b></p>
																<p>Thành tiền: <b>{{product.price | number}}</b> x <b>{{product.quantity}}</b> = <b>{{product.price * product.quantity | number}}</b> vnđ</p>
																<p>
																	<button class="btn btn-warning" style="width: auto;" ng-show="order.status==3 && !product.rating" ng-click="rate(order.id,product.productId)">Đánh giá</button>
																	<span ng-if="product.rating">Đánh giá của bạn: {{product.rating.content}}</span>
																</p>
															</td>

														</tr>
													</table>
												</td>
												<td>
													<p ng-if="order.createTime > 0">Đặt hàng lúc: {{order.createTime*1000 | date:"dd/MM/yyyy HH:mm:ss"}}</p>
													<p ng-if="order.confirmTime > 0">Xác nhận lúc: {{order.confirmTime*1000 | date:"dd/MM/yyyy HH:mm:ss"}}</p>
													<p ng-if="order.doneTime > 0">Hoàn thành lúc: {{order.doneTime*1000 | date:"dd/MM/yyyy HH:mm:ss"}}</p>
													<p ng-if="order.cancelTime > 0">Hủy lúc: {{order.cancelTime*1000 | date:"dd/MM/yyyy HH:mm:ss"}}</p>
													<p style="border-bottom: 1px solid #696969;"></p>
													<p>Phí vận chuyển: {{30000 | number}} vnđ</p>
													<p>Tiền hàng: {{order.totalPrice | number}} vnđ</p>
													<p>Tổng tiền: {{order.totalPrice*1 + 30000 | number}} vnđ</p>
													<p><a href="/hoa-don/{{order.id}}" target="_blank" class="btn btn-info">Hóa đơn</a></p>
													<p>
														Trạng thái :
														<span class="label label-warning" ng-if="order.status==0">Chờ xác nhận</span>
														<span class="label label-info" ng-if="order.status==1">Đã xác nhận</span>
														<span class="label label-primary" ng-if="order.status==2">Đang giao hàng</span>
														<span class="label label-success" ng-if="order.status==3">Đã giao hàng</span>
														<span class="label label-danger" ng-if="order.status==4">Đã hủy</span>
													</p>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div><!-- table-responsive -->
							<div class="b-form c-bill-filter">
								<div class="box-footer clearfix">
									<div class="no-margin pull-left">
										Tổng số {{ totalItem }} đơn hàng
									</div>
									<div class="no-margin pull-right">
										<ul class="pagination pagination-sm no-margin pull-right" ng-show="totalPage>1">
											<li><a href="javascript:;" ng-if="(page-1)>=1" ng-click="list(page-1);">«</a></li>
											<li><a href="javascript:;" ng-if="(page-2)>=1" ng-click="list(page-2);">{{(page-2)}}</a></li>
											<li><a href="javascript:;" ng-if="(page-1)>=1" ng-click="list(page-1);">{{(page-1)}}</a></li>
											<li ng-class="page?'active':'active'"><span>{{page}}</span></li>
											<li><a href="javascript:;" ng-if="(page+1)<=totalPage" ng-click="list(page+1);">{{(page+1)}}</a></li>
											<li><a href="javascript:;" ng-if="(page+2)<=totalPage" ng-click="list(page+2);">{{(page+2)}}</a></li>
											<li><a href="javascript:;" ng-if="(page+1)<=totalPage" ng-click="list(page+1);">»</a></li>
										</ul>
									</div>
								</div>
							</div>

						</div><!-- c-whitebox__inner -->
					</div><!-- c-whitebox__content -->
				</div><!-- c-whitebox -->
			</div><!-- l-main --> 
			<?php echo UserSidebar::widget(); ?>
		</div><!-- clearfix -->
	</div><!-- l-content -->
</div><!-- container -->