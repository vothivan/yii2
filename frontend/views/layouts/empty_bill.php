<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\Navigation;
use frontend\widgets\Footer;
use frontend\widgets\Modal;
use frontend\assets\AppAsset;
use yii\helpers\Json;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta http-equiv="content-language" content="vi"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta property="fb:app_id" content="115396375189605"/>
        <meta name="keywords" content="<?= @$this->params['keywords'] ?>"/>
        <meta name="description" content="<?= @$this->params['description'] ?>"/>
        <?php
        if (isset($this->params['og'])) {
            foreach ($this->params['og'] as $key => $value) {
                echo '<meta property="og:' . $key . '" content="' . $value . '"/>';
            }
            if (isset($this->params['og']['url'])) {
                echo '<link rel="canonical" href="' . $this->params['og']['url'] . '"/>';
            }
        }
        if (isset($this->params['noindex'])) {
            echo '<meta name="robots" content="noindex" />';
        }
        ?>
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="<?= Url::base() ?>/static/images/favicon.ico" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body ng-app="app">
    <?php $this->beginBody(); ?>
    <?= $content ?>
    <script>
        var baseUrl = '<?= Url::base() ?>';
    </script>
    <?php $this->endBody(); ?>
    <script>
        $(document).ready(function () {
            <?= Yii::$app->controller->clientScript ?>;
        });
    </script>
    <div id="fb-root"></div>
    <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=115396375189605";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
         (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
         m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
         })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

         ga('create', 'UA-83929839-1', 'auto');
         ga('send', 'pageview');

        !function (f, b, e, v, n, t, s) {
            if (f.fbq)return;
            n = f.fbq = function () {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq)f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '156512524771845');
        fbq('track', "PageView");

        var customer = <?= Json::encode(Yii::$app->user->identity) ?>;
        var maxWeight = <?= Yii::$app->params['maxWeight'] ?>;
        if (customer != null) {
            var buyer = {
                buyerName: customer.name,
                buyerEmail: customer.email,
                buyerPhone: customer.phone,
                buyerAddress: customer.address,
                buyerProvinceId: customer.provinceId,
                buyerDistrictId: customer.districtId
            };
        }

        var imboClient = new Imbo.Client({
            hosts: <?= json_encode(Yii::$app->params['imgServerUrls']) ?>,
            user: <?= json_encode(Yii::$app->params['imgUser']) ?>,
            publicKey: <?= json_encode(Yii::$app->params['imgUser']) ?>,
            privateKey: <?= json_encode(Yii::$app->params['imgPrivateKey']) ?>
        });
    </script>
    </body>
    </html>
<?php $this->endPage(); ?>
