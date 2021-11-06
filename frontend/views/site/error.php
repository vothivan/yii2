<?php
use yii\helpers\Url;

?>

<div class="container container-v2">
  <div class="l-content">
    <ol class="breadcrumb">
      <li><a href="#">Trang chủ</a></li>
      <li class="active">404</li>
    </ol>
    <div class="c-whitebox">
      <div class="c-whitebox__inner">
        <div class="c-error">
          <div class="row">
            <div class="col-md-6">
              <div class="c-error__img"><img src="<?= Url::base() ?>/static/images/404.jpg" alt="404" /></div>
            </div><!-- col -->
            <div class="col-md-6">
              <div class="c-error__content">
                <div class="c-error__title">Không tồn tại</div>
                <div class="b-maincontent">
                  Nội dung bạn tìm kiếm không tồn tại hoặc đã bị xóa khỏi website
                  <br />Xin vui lòng liên hệ tới <b class="text-danger">1900 989 888</b> để được hỗ trợ miễn phí
                </div>
                <ul>
                  <li><a href="<?= Url::home() ?>"><i class="fa fa-home"></i><span>Trang chủ</span></a></li>
                  <li><a href="#"><i class="fa fa-phone"></i><span>Liên hệ</span></a></li>
                </ul>
              </div>
            </div><!-- col -->
          </div><!-- row -->
        </div><!-- c-error -->
      </div><!-- c-whitebox__inner -->
    </div><!-- c-whitebox -->
  </div><!-- l-content -->
</div><!-- container -->