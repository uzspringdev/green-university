<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/common/config/bootstrap.php';
require __DIR__ . '/frontend/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common/config/main.php',
    require __DIR__ . '/common/config/main-local.php',
    require __DIR__ . '/frontend/config/main.php',
    require __DIR__ . '/frontend/config/main-local.php'
);

$application = new yii\web\Application($config);

use common\models\Menu;

$menuMain = Menu::findOne(['code' => 'main']);
$menuMainMenu = Menu::findOne(['code' => 'main-menu']);

echo "Checking Menu codes:\n";
echo "Code 'main': " . ($menuMain ? "Found (ID: {$menuMain->id})" : "Not Found") . "\n";
echo "Code 'main-menu': " . ($menuMainMenu ? "Found (ID: {$menuMainMenu->id})" : "Not Found") . "\n";

if ($menuMainMenu) {
    echo "Items in 'main-menu': " . $menuMainMenu->getMenuItems()->count() . "\n";
}
