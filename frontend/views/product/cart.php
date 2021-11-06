<?php

use yii\helpers\Url;
?>
<div class="container container-v2" ng-controller="order" ng-cloak>
	<div class="l-content">
		<ol class="breadcrumb">
			<li><a href="#">Trang chủ</a></li>
			<li class="active">Giỏ hàng</li>
		</ol>
		<div class="c-checkout clearfix">

				<div class="c-checkout-right">
				<div class="c-whitebox">
					<div class="c-whitebox__title">
						<div class="c-whitebox__title__name">Sản phẩm đã chọn</div>
						<div class="c-whitebox__title__more">
						</div>
					</div>
					<div class="c-whitebox__content"  ng-show="orders.length > 0" >
						<div class="c-whitebox__inner" ng-repeat="item in orders">
							<div class="c-checkout-product">
								<div class="b-grid">
									<div class="b-grid__img"><a ng-href="{{item.url}}"><img ng-src="/{{item.image}}"/></a></div>
									<div class="b-grid__price">
										<span class="c-checkout-right__price">{{item.price * getNumberProduct(item.id) | number}}<sup>đ</sup></span>
									</div>
									<a class="b-grid__remove" href="#" ng-click="removeInCart(item.id)">Xoá</a>
									<div class="b-grid__content">
										<div class="b-grid__row"><a class="b-grid__title" ng-href="{{item.url}}">{{item.name}}</a></div>
										<div class="b-grid__row">
											<div class="c-count">
												<span class="c-count__minus" ng-click="removecart(item.id)">-</span>
												<input type="text" class="form-control" ng-model="getNumberProduct(item.id)" disabled>
												<span class="c-count__plus" ng-click="addcart(item.id)">+</span>
											</div>
											<span class="b-grid__smallprice">{{getNumberProduct(item.id)}} x {{item.price | number}}<sup>đ</sup></span>
										</div>
									</div>
								</div><!-- b-grid -->
							</div><!-- c-checkout-product -->
						</div><!-- c-whitebox__inner -->
						<div class="c-whitebox__inner has-border-top">
							<div class="c-checkout__row">
								<span>Phí vận chuyển:</span>
								<span class="c-checkout-right__number">{{30000|number}}<sup>đ</sup></span>
							</div>
							<div class="c-checkout__row">
								<span>Giá trị gói hàng:</span>
								<span class="c-checkout-right__total">{{totalPrice()|number}}<sup>đ</sup></span>
							</div>
						</div><!-- c-whitebox__inner -->
					</div><!-- c-whitebox__content -->
				</div><!-- c-whitebox -->
				<div class="c-checkout-bill">
					<div class="c-checkout-bill__row is-big">
						<label>Tổng cộng giá trị đơn hàng:</label>
						<span class="c-checkout-bill__total"><span ng-bind="totalPrice() + 30000 | number">0</span><sup>đ</sup></span>
					</div>
				</div>
			</div><!-- c-checkout-right -->
			<div class="c-checkout-left">
				<div class="c-whitebox">
					<div class="c-whitebox__title">
						<div class="c-whitebox__title__name">Thông tin người mua</div>
						<div class="c-whitebox__title__more"></div>
					</div>
					<div class="c-whitebox__content">
						<div class="c-whitebox__inner">
							<div class="b-form form-horizontal">

								<div class="form-group" ng-class="errors.contactName?'has-error':''">
									<label class="control-label col-sm-4">Họ và tên<span class="text-danger">(*)</span></label>
									<div class="col-sm-8">
										<input class="form-control" type="text" ng-model="buyer.contactName" placeholder="" />
										<small class="help-block" ng-class="errors.contactName?'scroll-error':''" ng-if="errors.contactName">{{errors.contactName[0]}}</small>
									</div>
								</div>
								<div class="form-group" ng-class="errors.contactPhone?'has-error':''">
									<label class="control-label col-sm-4">Số điện thoại<span class="text-danger">(*)</span></label>
									<div class="col-sm-8">
										<input class="form-control" type="text" ng-model="buyer.contactPhone" placeholder="" />
										<small class="help-block" ng-class="errors.contactPhone?'scroll-error':''" ng-if="errors.contactPhone">{{errors.contactPhone[0]}}</small>
									</div>
								</div>
								<div class="form-group" ng-class="errors.contactEmail?'has-error':''">
									<label class="control-label col-sm-4">Email</label>
									<div class="col-sm-8">
										<input class="form-control" type="text" ng-model="buyer.contactEmail" placeholder="" />
										<small class="help-block" ng-class="errors.contactEmail?'scroll-error':''" ng-if="errors.contactEmail">{{errors.contactEmail[0]}}</small>
									</div>
								</div>
								<div class="form-group" ng-class="errors.address?'has-error':''">
									<label class="control-label col-sm-4">Địa chỉ nhận hàng<span class="text-danger">(*)</span></label>
									<div class="col-sm-8">
										<input class="form-control" type="text" ng-model="buyer.address" placeholder="" />
										<small class="help-block" ng-class="errors.address?'scroll-error':''" ng-if="errors.address">{{errors.address[0]}}</small>
									</div>
								</div>
								<div class="form-group" ng-class="errors.note?'has-error':''">
									<label class="control-label col-sm-4">Ghi chú</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="3" ng-model="buyer.note" placeholder=""></textarea>
										<small class="help-block" ng-class="errors.note?'scroll-error':''" ng-if="errors.note">{{errors.note[0]}}</small>
									</div>
								</div>
							</div><!-- /.form -->

							<p>Chú ý: chỉ giao hàng đến địa chỉ quanh cửa hàng phạm vi 15km.</p>
						</div><!-- c-whitebox__inner -->

					</div><!-- c-whitebox__content -->
				</div><!-- c-whitebox -->
				<div class="c-checkout-bill">
					<div class="c-checkout-bill__row is-big">
						<label>Tổng giá trị đơn hàng</label>
						<span class="c-checkout-bill__total"><span ng-bind="totalPrice() | number">0</span><sup>đ</sup></span>
					</div>
				</div>
				<div class="c-whitebox">
					<div class="c-whitebox__title">
						<div class="c-whitebox__title__name">Phương thức thanh toán</div>
					</div>
					<div class="c-whitebox__content">
						<div class="c-whitebox__inner">
							<div class="c-payments">
								<div class="c-payments-item active">
									<div class="c-payments-item__title">
										<div class="b-grid">
											<div class="b-grid__img"><img src="/static/images/icons/icon48-money.png" alt="payment 1" /></div>
											<div class="b-grid__content">
												<div class="b-grid__row"><span class="b-grid__title">Hình thức COD, nhận hàng và thanh toán</span></div>
											</div>
										</div>
									</div>
									<div class="c-payments-item__content" style="display: block;">
										<div class="c-payments-item__button">
											<a class="btn btn-secondary btn-lg" ng-click="ok()">Tiến hành đặt hàng</a>
										</div>
									</div>
								</div>
							</div><!-- c-payments -->
						</div><!-- c-whitebox__inner -->
					</div><!-- c-whitebox__content -->
				</div><!-- c-whitebox -->
				<div class="c-checkout-next">
					<a class="btn btn-default" href="/">Quay lại mua sắm</a>
				</div>
			</div><!-- c-checkout-left -->
		

		</div><!-- c-checkout -->
	</div><!-- l-content -->
</div><!-- container -->