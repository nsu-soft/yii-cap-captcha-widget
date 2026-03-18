<?php

use NsuSoft\Captcha\Cap;
use yii\helpers\ArrayHelper;

$captcha = require __DIR__ . '/captcha.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'library-tests',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'basePath' => dirname(__DIR__),
    'components' => [
        'assetManager' => [
            'basePath' => dirname(__DIR__) . '/web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
        'captcha' => ArrayHelper::merge($captcha, [
            'class' => Cap::class,
        ]),
    ],
];