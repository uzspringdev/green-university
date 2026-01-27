<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'on beforeRequest' => function ($event) {
        $session = Yii::$app->session;
        if ($session->has('language')) {
            Yii::$app->language = $session->get('language');
        } elseif ($cookie = Yii::$app->request->cookies->get('language')) {
            Yii::$app->language = $cookie->value;
        }
    },
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'news' => 'news/index',
                'news/<slug>' => 'news/view',
                'announcement' => 'announcement/index',
                'announcement/<id:\d+>' => 'announcement/view',
                'application' => 'application/index',
                'contact' => 'site/contact',
                'about' => 'site/about',
                // Fallback for dynamic pages - match anything except existing routes
                '<slug:[\w-]+>' => 'page/view',
            ],
        ],
    ],
    'params' => $params,
];
