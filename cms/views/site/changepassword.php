<?php

use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\grid\Column;
use yii\helpers\Url;
use cms\widgets\Messages;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<section class="content-header">
    <h1>
        Đổi mật khẩu
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= Url::home() ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Đổi mật khẩu</li>
    </ol>
</section>
<!-- Main content -->
<section class="content" ng-cloak>
    <?php echo Messages::widget(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="nav-tabs-custom">
              <div class="row" style="margin-bottom: 10px">
                  <div class="col-sm-12">
                      <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-6">
                                  <?php $form = ActiveForm::begin([
                                      'id' => 'login-form',
                                      'options' => ['class' => 'form-horizontal'],
                                  ]) ?>
                                  <?= $form->field($model, 'oldpass')->passwordInput() ?>
                                  <?= $form->field($model, 'newpass')->passwordInput() ?>
                                  <?= $form->field($model, 'repeatnewpass')->passwordInput() ?>
                                  <div class="form-group">
                                      <?= Html::submitButton('Lưu',[
                                          'class'=>'btn btn-primary'
                                      ]) ?>
                                  </div>
                                  <?php ActiveForm::end() ?>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</section>
