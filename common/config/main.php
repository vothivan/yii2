<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'vi-VN',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'components' => [
        // 'mailer' => [
        //     'class' => 'yii\swiftmailer\Mailer',
        //     'viewPath' => '@common/mail',
        //     'useFileTransport' => false,
        //     'transport' => [
        //         'class' => 'Swift_SmtpTransport',
        //         'host' => 'mail.vnpost.vn',
        //         'username' => 'voso',
        //         'password' => 'VNP@2018',
        //         'port' => '25',
        //     ],
        // ],
        'i18n' => array(
            'translations' => array(
                'eauth' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@eauth/messages',
                ),
                'frontend' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => ''
                ],
            ),
        ),
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'UTC',
            'timeZone' => 'Asia/Ho_Chi_Minh',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'currencyCode' => 'VNĐ',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
    ],
];
