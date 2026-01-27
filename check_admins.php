<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/common/config/bootstrap.php';
require __DIR__ . '/backend/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common/config/main.php',
    require __DIR__ . '/common/config/main-local.php',
    require __DIR__ . '/backend/config/main.php',
    require __DIR__ . '/backend/config/main-local.php'
);

$application = new yii\web\Application($config);

use common\models\User;

$admins = User::find()->where(['role' => [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN]])->all();

echo "Admins found: " . count($admins) . "\n";
foreach ($admins as $admin) {
    echo "ID: " . $admin->id . " | Username: " . $admin->username . " | Role: " . $admin->role . "\n";
}
