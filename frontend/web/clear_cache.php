<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php'
);

$application = new yii\web\Application($config);

// Flush Schema Cache
if (Yii::$app->db->schema->refresh()) {
    echo "✅ Database Schema Refreshed.<br>";
} else {
    echo "❌ Failed to refresh Schema.<br>";
}

// Flush General Cache
if (Yii::$app->cache->flush()) {
    echo "✅ General Cache Flushed.<br>";
}

// Delete runtime directory contents recursively (optional/aggressive)
echo "<br>Checking runtime permissions...<br>";
$runtime = Yii::getAlias('@frontend/runtime/cache');
if (is_writable($runtime)) {
    echo "✅ Runtime directory is writable: $runtime<br>";
} else {
    echo "❌ Runtime directory is NOT writable: $runtime (Try 'chown -R www-data:www-data ...')<br>";
}

echo "<hr>Done. Try refreshing the home page.";
