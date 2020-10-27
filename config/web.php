<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Guitar-chords.space',
    'sourceLanguage'=>'en',
    'language'=>'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'ESf_xzpyWnHTo_T2geDz28-jOjNJHAVr',
            'class' => 'app\components\Request',
            'baseUrl' => ''
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'assetManager' => [
            'appendTimestamp' => true,
            'class' => 'yii\web\AssetManager',
        ],
        'urlManager' => [
            'class'=>'\app\components\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'sitemap' => 'site/sitemap',
                '/' => 'site/generator',
                'set-fingering/<id>' => 'site/set-fingering',
                'set-fingering' => 'site/set-fingering',
                'fingers/<toneId>/<typeId>' => 'site/fingers',
                'fingers' => 'site/fingers',
                '<action:(chord|chords|generator)>/<id:\d+>' => 'site/<action>',
                'chords' => 'site/chords',
            ],
        ],
        'view'         => [
            'class'           => '\rmrevin\yii\minify\View',
            'enableMinify'    => !YII_DEBUG,
            'concatCss'       => true, // concatenate css
            'minifyCss'       => true, // minificate css
            'concatJs'        => true, // concatenate js
            'minifyJs'        => true, // minificate js
            'minifyOutput'    => true, // minificate result html page
            'webPath'         => '', // path alias to web base
            'basePath'        => '@webroot', // path alias to web base
            'minifyPath'      => '@webroot/minify', // path alias to save minify result
            'jsPosition'      => [\yii\web\View::POS_END], // positions of js files to be minified
            'forceCharset'    => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expandImports'   => true, // whether to change @import on content
            'compressOptions' => ['extra' => true], // options for compress
            'compress_output' => true,
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
