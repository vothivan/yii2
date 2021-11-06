<?php

return [
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                // 'google' => [
                //     'class' => 'yii\authclient\clients\Google',
                //     'clientId' => '165480646657-bdkda22r50etukgv28vq4ta6qu1m92sc.apps.googleusercontent.com',
                //     'clientSecret' => '-DU8CQFZAoBO7yffm5uKeK33',
                // ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '2173360542976566',
                    'returnUrl' => 'https://voso.vn/login/facebook',
                    'clientSecret' => '417aa6d3534cc9127b8e39ab7db50e73',
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=zoshop',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => false,
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=103.9.79.197;port=9306;',
            'username' => '',
            'password' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'hostInfo' => 'voso.local',
        ],
        'view' => [
			'class' => '\rmrevin\yii\minify\View',
			'enableMinify' => !YII_DEBUG,
			'concatCss' => true, // concatenate css
			'minifyCss' => true, // minificate css
			'concatJs' => true, // concatenate js
			'minifyJs' => true, // minificate js
			'minifyOutput' => true, // minificate result html page
			'webPath' => '@web', // path alias to web base
			'basePath' => '@webroot', // path alias to web base
			'minifyPath' => '@webroot/minify', // path alias to save minify result
			'jsPosition' => [ \yii\web\View::POS_END ], // positions of js files to be minified
			'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
			'expandImports' => true, // whether to change @import on content
			'compressOptions' => ['extra' => true], // options for compress
			'excludeFiles' => [
            	'jquery.js', // exclude this file from minification
            	'app-[^.].js', // you may use regexp
            ],
            'excludeBundles' => [
            	\app\helloworld\AssetBundle::class, // exclude this bundle from minification
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'emailnapdanh@gmail.com',
                'password' => 'vinhqwert',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
    ],
];
