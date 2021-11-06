<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'assets2/style.min.css',
        'assets2/style.css',
        'assets2/woocommerce.css',
        'assets2/skin.css',
        'assets2/cloudzoom.css',
        'assets2/css1.css',
        'assets2/css2.css',
        'assets2/dashicons.min.css',
        'assets2/js-image-slider.css',
        'assets2/lightgallery.css',
        'assets2/js-image-slider.css'
    ];
    public $js = [
        'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
        'assets2/jquery-migrate.min.js',
        'assets2/js-image-slider.js',
        'assets2/jquery.blockUI.min.js',
        'assets2/woocommerce.min.js',
        'assets2/jquery.cookie.min.js',
        'assets2/cart-fragments.min.js',
        'assets2/tie-scripts.js',
        'assets2/ilightbox.packed.js',
        'assets2/picturefill.min.js',
        'assets2/lightgallery-all.min.js',
        'assets2/jquery.mousewheel.min.js',
        'assets2/cloudzoom.js',
        'assets2/search.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
        // 'yii\bootstrap\BootstrapPluginAsset',
        // 'rmrevin\yii\fontawesome\AssetBundle',
    ];

}
