<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace cms\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/text-angular.css',
        'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.7.0/spectrum.min.css',
        'css/angular-toggle-switch-bootstrap-3.css',
        'css/customSelect.css',
        'css/colorpicker.min.css'
    ];
    public $js = [
        'js/lib/angular.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.7.0/spectrum.min.js',
        'js/lib/angular-spectrum-colorpicker.min.js',
        'js/lib/angular-animate.min.js',
        'js/lib/textAngular-dropdownToggle.js',
        'js/lib/angular-ui-bootstrap.min.js',
        'js/lib/bootstrap-colorpicker-module.min.js',
        'js/lib/angular-filedialog.js',
        'js/lib/text-angular-rangy.min.js',
        'js/lib/text-angular-sanitize.min.js',
        'js/lib/textAngularSetup.js',
        'js/lib/textAngular.min.js',
        'js/lib/text-angular.min.js',
        'js/lib/text-angular-setup.js',
        'js/lib/moment.min.js',
        'js/lib/angular-moment.min.js',
        'js/lib/chart.min.js',
        'js/lib/angular-chart.min.js',
        // 'js/lib/ng-sortable.min.js',
        'js/lib/sortable.min.js',
        'js/lib/angular-legacy-sortable.js',
        'js/lib/imboclient.min.js',
        'js/lib/bootbox.js',
        'js/lib/customSelect.js',
        'js/lib/angular-toggle-switch.min.js',
        'js/lib/datetimepicker.js',
        'js/app.js',
        'js/utils.js',
        'js/product.js',
        'js/news.js',
        'js/home.js',
        'js/customer.js',
        'js/card.js',
        'js/order.js',
        'js/urgent.js',
        'js/smbox.js',
        'js/report.js',
        'js/restaurant-view.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'dmstr\web\AdminLteAsset',
    ];

}
