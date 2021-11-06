<?php

use cms\assets\AppAsset;
use cms\widgets\Navigation;
use cms\widgets\Footer;
use yii\helpers\Html;
use \dmstr\helpers\AdminLteHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html ng-app="app" lang="<?= Yii::$app->language ?>">

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

<body class="<?= AdminLteHelper::skinClass() ?> hold-transition  sidebar-open fixed">
<?php $this->beginBody() ?>
<div class="wrapper" ng-cloak>
    <?= Navigation::widget() ?>
    <div class="content-wrapper">
        <?= $content ?>
    </div>
    <?= Footer::widget() ?>
</div>

<script>
    var baseUrl = '<?= yii\helpers\Url::base() ?>';
    var frontendUrl = '<?= Yii::$app->params['frontendBaseUrl'] ?>';
</script>
<?php $this->endBody() ?>
<script>
    var imboClient = new Imbo.Client({
        hosts: <?= json_encode(Yii::$app->params['imgServerUrls']) ?>,
        user: <?= json_encode(Yii::$app->params['imgUser']) ?>,
        publicKey: <?= json_encode(Yii::$app->params['imgUser']) ?>,
        privateKey: <?= json_encode(Yii::$app->params['imgPrivateKey']) ?>
    });
    $(document).ready(function () {
        <?= Yii::$app->controller->clientScript ?>;
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
