<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-cms',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'cms\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Staff',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'assignmentFile' => '@cms/runtime/assignments.php',
            'itemFile' => '@cms/runtime/items.php',
            'ruleFile' => '@cms/runtime/rules.php',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
            ],
            'appendTimestamp' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'VMbCkPbQc77Xr5BW2o1NbBmgeOEAXSFs',
        ]
    ],
    'params' => $params,
];
