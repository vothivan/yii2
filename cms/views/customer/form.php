<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\GameNro;
?>

<section class="content-header">
	<h1><?= Html::encode($this->title) ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= Url::home() ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<?php if (Yii::$app->session->hasFlash('error')): ?>
				<div class="alert alert-danger" role="alert">
					<?= Yii::$app->session->getFlash('error') ?>
				</div>
			<?php endif; ?>
			<?php if (Yii::$app->session->hasFlash('success')): ?>
				<div class="alert alert-success" role="alert">
					<?= Yii::$app->session->getFlash('success') ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="box">
				<div class="box-header with-border">

				</div><!-- /.box-header -->
				<?php $form = ActiveForm::begin(); ?>
				<div class="box-body">
					<div class="col-lg-12">
						<div class="col-lg-6">
							<?= $form->field($model, 'name') ?>
							<?= $form->field($model, 'phone') ?>
							<?= $form->field($model, 'email') ?>
							<?= $form->field($model, 'address') ?>
							<?= $form->field($model, 'description') ?>
							<?= $form->field($model, 'status')->checkbox() ?>
							<?= $form->field($model, 'password', ['inputOptions' => ['autocomplete' => 'new-password']])->passwordInput() ?>
							<?= $form->field($model, 'repassword', ['inputOptions' => ['autocomplete' => 'new-password']])->passwordInput() ?>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<?= Html::submitButton($act, ['class' => 'btn btn-primary']) ?>
					<?= Html::a('Quay lại', Url::to(['index']), ['class' => 'btn btn-default']) ?>
				</div>
				<?php ActiveForm::end(); ?>
			</div><!-- /.box -->
		</div><!-- /.col-lg-12 -->
	</div><!-- /.row -->
</section>
