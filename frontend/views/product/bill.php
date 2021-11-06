<?php 
use yii\helpers\Json;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>
	<style>
	body {
		font-family: 'Open Sans', sans-serif;
	}
	.top_button, .ta-hidden-input {
		display: none !important;
	}
	table {
		width: 100%;
	}

	.info {
		border-bottom: 1px solid #696969;
	}

	.info td {
	}

	.product {
		border-bottom: 1px solid #696969;
	}

	.product td {
		padding: 5px;
	}
	.bar-bill{
		height: 40px;
		line-height: 3;
		border-bottom: 1px solid black;
		padding: 0 40px;
	}
	.bar-bill-a{
		text-decoration: none !important;
	}
</style>
<title> Hóa đơn </title>
</head>
<body>
	<div class="bar-bill">
		<a href="/" class="bar-bill-a"><i class="fa fa-chevron-left"></i><b> Quay lại</b></a>
	</div>

	<div class="main" style="position: relative;max-width: 400px;margin: auto;border: 1px solid #696969; margin-top: 25px;">
		<table style="width: 100%;">
			<tr>
				<td style="width: 50%">
					<img src="/static/images/zoshop-2.png" width="100%">
				</td>
				<td style="width: 50%;text-align: center;"><?=Yii::$app->controller->address?></td>
			</tr>
		</table>
		<div style="text-align: center;font-size: 30px;">Hóa đơn</div>
		<?php if(in_array($model->status, [0,1,2])){ ?>
		<img src="/static/images/chuathanhtoan.png" style="position: absolute;top: 230px;left: 212px;transform: rotate(-28deg)">
		<?php } ?>
		<table class="info">
			<tr>
				<td>Mã hóa đơn: <b><?= $model->id ?></b></td>
				<td>Trạng thái: 
					<?php if($model->status == 0){ ?><b>chờ duyệt</b> 		<?php } ?>
					<?php if($model->status == 1){ ?><b>đã duyệt</b> 		<?php } ?>
					<?php if($model->status == 2){ ?><b>đang giao hàng</b> 	<?php } ?>
					<?php if($model->status == 3){ ?><b>đã giao hàng</b> 	<?php } ?>
					<?php if($model->status == 4){ ?><b>hủy</b> 			<?php } ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>Khách hàng: <b><?= $model->contactName ?></b></p>
					<p>Số điện thoại: <b><?= $model->contactPhone ?></b></p>
					<?php if($model->contactEmail){ ?>
					<p>Email: <b><?= $model->contactEmail ?></b></p>
					<?php } ?>
					<p>Địa chỉ: <b><?= $model->address ?></b></p>
					<p>Ghi chú: <i><?= $model->note ?></i></p>
				</td>
			</tr>
		</table>
		<table class="product">
			<tr>
				<td><b>Sản phẩm</b></td>
				<td><b>Đơn giá</b></td>
				<td><b>Số lượng</b></td>
				<td><b>Thành tiền</b></td>
			</tr>
			<?php  
			foreach($model->products as $product) {  $p = Json::decode($product->productData); ?>
			<tr>
				<td><?= $p['name'] ?></td>
				<td><?= number_format($product->price) ?></td>
				<td><?= number_format($product->quantity) ?></td>
				<td><?= number_format($product->price * $product->quantity) ?></td>
			</tr>
			<?php } ?>

		</table>
		<table style="width: 100%;">
			<tr>
				<td colspan="3" style="text-align: center;"><b>Phí vận chuyển:</b></td>
				<td><b style="font-size: 27px; color: #ff0000;"><?= number_format(30000) ?></b> vnđ</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center;"><b>Tổng tiền:</b></td>
				<td><b style="font-size: 27px; color: #ff0000;"><?= number_format($model->totalPrice + 30000) ?></b> vnđ</td>
			</tr>
		</table>
		<div style="padding: 30px;font-size: 20px;text-align: center;">
			Website: zoshop.vn
		</div>
	</div>
</body>
</html>