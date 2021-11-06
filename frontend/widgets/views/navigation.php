<?php

use yii\helpers\Url;
use common\components\ImageClient;
use common\models\Category;
use common\models\Keyword;
use common\models\Urls;
?>
<div class="l-nav" ng-controller="auth" ng-init="init()">
  <div class="c-nav-top">
    <div class="container container-v2">
      <button type="button" class="c-menu-expand js-menu-expand"><span></span></button>
      <div class="c-nav-left">
        <div class="c-menu-top">
          <ul>
            <li class="c-menu-top__sp"><a href="tel:<?=Yii::$app->controller->contactPhone?>"><i class="fa fa-phone"></i><span class="c-menu-top__text"><?=Yii::$app->controller->contactPhone?></span></a></li>
            <li class="c-menu-top__sp"><a href="mailto:<?=Yii::$app->controller->contactEmail?>"><i class="fa fa-envelope"></i><span class="c-menu-top__text"><?=Yii::$app->controller->contactEmail?></span></a></li>
          </ul>
        </div><!-- c-menu-top -->
      </div><!-- c-nav-left -->
      <div class="c-nav-right">
        <div class="c-menu-top">
          <ul>
            <li><a href="/">Kết nối</a></li>
          </ul>
        </div><!-- c-menu-top -->
      </div><!-- c-nav-right -->
    </div><!-- container -->
  </div><!-- c-nav-top -->
  <div class="c-header">
    <div class="container container-v2">
      <div class="c-header-inner">
        <div class="c-logo"><a href="/"><img src="static/images/zoshop-1.png" alt="logo" /></a></div>
        <div class="c-search">
          <div class="c-search__inner" ng-controller="search">
            <input type="text" id="inputSearch" ng-change="type()" ng-model="keyword" maxlength="100"
            autocomplete="off" value="<?= @$this->params['keywords'] ?>"
            ng-keyup="complete(keyword)" 
            ng-focus="suggest = true;"
            ng-blur="suggest = false;"
            name="" class="form-control ng-touched input-search-home" placeholder="Nhập sản phẩm bạn muốn tìm kiếm..." ng-keypress="enterSearch($event)"/>
            <button ng-click="search()" class="c-search__btn"><i class="fa fa-search"></i></button>
          </div>
        </div><!-- c-search -->
        <?php if (Yii::$app->user->isGuest) { ?>
        <div class="c-admin">
          <ul>
            <li class="c-admin__login">
              <a href="javascript:void(0);"><i class="fa fa-user"></i><span class="c-admin__text">Tài khoản</span></a>
              <div class="c-dropdown-menu is-circle is-right">
                <ul>
                  <li><a class="btn btn-primary text-uppercase" href="#" ng-click="signin()">Đăng nhập</a></li>
                  <li><a class="btn btn-primary text-uppercase" href="#" ng-click="signup()">Đăng ký</a></li>
                  <!-- <li><a class="btn bg-facebook text-uppercase" href="#" ng-click="signinfb()"><i class="fa fa-facebook-f"></i>Đăng nhập với Facebook</a></li> -->
                </ul>
              </div>
            </li>
          </ul>
        </div>
      <?php }else{ ?>
        <div class="c-admin dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
            <i class="fa fa-user"></i><span class="c-admin__text"><?= Yii::$app->user->identity->name ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="<?= Url::to(['user/index']) ?>">Thông tin cá nhân</a></li>
            <li><a href="<?= Url::to(['user/password']) ?>">Đổi mật khẩu</a></li>
            <li><a href="<?= Url::to(['user/order']) ?>">Lịch sử đơn hàng</a></li>
            <li><a ng-click="signout()" href="#">Thoát</a></li>
          </ul>
        </div>
      <?php } ?>
        <div class="c-cart">
          <a href="<?= Url::to(['product/cart']) ?>"><i class="fa fa-shopping-cart"></i><span class="c-cart__text">Giỏ hàng (<span id="cuccac">0</span>)</span></a>
        </div>
      </div><!-- c-header-inner -->
    </div><!-- container -->
  </div><!-- c-header -->
  <div class="c-menu-outer">
    <div class="container container-v2">
      <div class="c-menu-inner">
        <div class="c-app-ovelay js-app-ovelay"></div>
        <div class="c-alias">
          <div class="c-alias__btn"><i class="fa fa-list-ul"></i>Danh mục sản phẩm<i class="fa fa-chevron-down"></i></div>
          <div class="c-alias__expand">
            <span class="c-alias-close js-alias-close"><i class="fa fa-long-arrow-left"></i></span>
            <ul>
              <?php foreach (Category::find()->andWhere(['status' => 1])->all() as $category): ?>
              <li class="is-single"><a href="<?= $category->createUrl() ?>"><?= $category->name ?></a></li>
              <?php endforeach ?>
            </ul>
          </div><!-- c-alias__expand -->
        </div><!-- c-alias -->
        <button type="button" class="c-menusecond-expand js-menusecond-expand"><i class="fa fa-bars"></i>Menu</button>
        <div class="c-menu">
          <ul>
            <li class="c-menu__commit"><i class="icon48-commit_1"></i><span class="c-menu__text">2 tiếng nhận hàng với hàng nghìn sản phẩm</span></li>
            <li class="c-menu__commit"><i class="icon48-commit_2"></i><span class="c-menu__text">Tất cả sản phẩm 100% Chính hiệu</span></li>
          </ul>
        </div><!-- c-menu -->
      </div><!-- c-menu-inner -->
    </div><!-- container -->
  </div><!-- c-menu-outer -->
</div><!-- l-nav -->