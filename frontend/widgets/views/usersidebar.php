<?php

use yii\helpers\Url;
use common\components\ImageClient;

?>

<div class="l-sidebar is-normal">
	<div class="c-whitebox">
		<div class="c-whitebox__title">
			<div class="c-whitebox__title__name">Quản lý cá nhân</div>
		</div>
		<div class="c-whitebox__content">
			<div class="c-sidebar-menu">
				<ul>
					<li class="<?= Yii::$app->session->getFlash('usersidebar')=='index'?'active':'' ?>"><a href="<?= Url::to(['user/index']) ?>">Thông tin cá nhân </a></li>
					<li class="<?= Yii::$app->session->getFlash('usersidebar')=='password'?'active':'' ?>"><a href="<?= Url::to(['user/password']) ?>">Thay đổi mật khẩu </a></li>
				</ul>
			</div><!-- c-sidebar-menu -->
		</div><!-- c-whitebox__content -->
	</div><!-- c-whitebox -->
	<div class="c-whitebox">
		<div class="c-whitebox__title">
			<div class="c-whitebox__title__name">Quản lý mua hàng</div>
		</div>
		<div class="c-whitebox__content">
			<div class="c-sidebar-menu">
				<ul>
					<li class="<?= Yii::$app->session->getFlash('usersidebar')=='order'?'active':'' ?>"> <a href="<?= Url::to(['user/order']) ?>"><span><?=Yii::$app->session->getFlash('menu_profile') ?></span>Lịch sử đơn hàng</a></a></li>
				</ul>
			</div><!-- c-sidebar-menu -->
		</div><!-- c-whitebox__content -->
	</div><!-- c-whitebox -->
</div><!-- l-sidebar -->
