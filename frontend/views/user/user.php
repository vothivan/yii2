<?php
use yii\helpers\Url;
use common\models\ProductSearch;
use common\models\Keyword;
use common\components\ImageClient;
use frontend\widgets\UserSidebar;
use yii\widgets\ActiveForm;

?>

<div class="container container-v2" ng-controller="user" ng-cloak>
  <div class="l-content">
    <ol class="breadcrumb">
      <li><a href="#">Trang chủ</a></li>
      <li class="active">Thông tin cá nhân</li>
    </ol>
    <div class="clearfix">
      <div class="l-main is-normal">
        <div class="c-whitebox">
          <div class="c-whitebox__title">
            <div class="c-whitebox__title__name">Thông tin cá nhân</div>
            <?php if (Yii::$app->session->hasFlash('success')) { ?>
              <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
            <?php } ?>
            <?php if (Yii::$app->session->hasFlash('error')) { ?>
              <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error') ?></div>
            <?php } ?>
          </div>
          <div class="c-whitebox__content">
            <div class="c-whitebox__inner">
              <div class="b-form form-horizontal c-user-form">
                <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>
                <input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
                value="<?=Yii::$app->request->csrfToken?>"/>
      
                  <?= $form->field($model, 'name', [
                  'template' => '<div class="form-group">
                  <label class="control-label col-sm-4">Họ tên:</label>
                  <div class="col-sm-8"> {input} {error} </div>
                  </div>'
                  ]); ?>

                  <?= $form->field($model, 'phone', [
                  'template' => '<div class="form-group">
                  <label class="control-label col-sm-4">Số điện thoại:</label>
                  <div class="col-sm-8"> {input} {error} </div>
                  </div>'
                  ]); ?>
                  <?= $form->field($model, 'email', [
                  'template' => '<div class="form-group">
                  <label class="control-label col-sm-4">Email:</label>
                  <div class="col-sm-8"> {input} {error} </div>
                  </div>'
                  ]); ?>
                  <?= $form->field($model, 'address', [
                  'template' => '<div class="form-group">
                  <label class="control-label col-sm-4">Địa chỉ:</label>
                  <div class="col-sm-8"> {input} {error} </div>
                  </div>'
                  ]); ?>

                  <hr />
                  <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4">
                      <button type="submit" class="btn btn-secondary text-uppercase">Lưu lại</button>
                    </div>
                  </div>
                  <?php ActiveForm::end() ?>
              </div><!-- form -->
            </div><!--c-whitebox__inner -->
          </div><!-- c-whitebox__content -->
        </div><!-- c-whitebox -->
      </div><!-- l-main -->
         <?php echo UserSidebar::widget(); ?>
    </div><!-- clearfix -->
  </div><!-- l-content -->
</div><!-- container -->