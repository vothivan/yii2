<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<section class="content-header">
    <h1>
        Cài đặt thông tin
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= Url::home() ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li>Cài đặt thông tin</li>
    </ol>
</section>
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
                    <h3 class="box-title">Cài đặt thông tin</h3>
                </div>
                <?php $form = ActiveForm::begin(); ?>
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'companyName') ?>
                            <?= $form->field($model, 'contactPhone') ?>
                            <?= $form->field($model, 'contactEmail') ?>
                            <?= $form->field($model, 'slogan')->textarea(['rows' => 3]) ?>
                            <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
                            <?= $form->field($model, 'linkFb') ?>
                            <?= $form->field($model, 'linkGg') ?>
                            <?= $form->field($model, 'linkYt') ?>
                            <?= $form->field($model, 'linkZalo') ?>
                            <?= $form->field($model, 'linkInstagram') ?>
                        </div>
                        <div class="col-lg-6">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <?= Html::submitButton('Lưu thay đổi', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Quay lại', Url::to(['index']), ['class' => 'btn btn-default']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div><!-- /.box -->
        </div> <!-- /.col-lg-12 -->
    </div><!-- /.row -->
</section>
