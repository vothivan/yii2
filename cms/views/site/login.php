<?php

use cms\assets\AppAsset;
use cms\widgets\Navigation;
use cms\widgets\Footer;
use yii\helpers\Html;
use \dmstr\helpers\AdminLteHelper;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition login-page">
    <?php $this->beginBody() ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= Url::home() ?>"><b>Hệ thống quản trị</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <!-- <p class="login-box-msg">Đăng nhập hệ thống quản trị</p> -->

            <?= Html::beginForm() ?>
            <div class="form-group has-feedback">
                <input type="username" name="username" class="form-control" placeholder="Tên đăng nhập">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <?php if (Yii::$app->session->hasFlash('error')) { ?>
                <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error') ?></div>
            <?php } ?>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox"> Tự động đăng nhập lần sau
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                </div>
                <!-- /.col -->
            </div>
            <?= Html::endForm() ?>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
