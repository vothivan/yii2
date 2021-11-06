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
<body>
<?=$content?>
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
