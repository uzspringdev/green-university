<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'prod');

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

echo "--- Connection Info ---\n";
echo "DSN: " . Yii::$app->db->dsn . "\n";
echo "Driver: " . Yii::$app->db->driverName . "\n";

echo "\n--- Schema Info for 'menu' ---\n";
$schema = Yii::$app->db->getTableSchema('menu');
if ($schema) {
    echo "Table Name: " . $schema->name . "\n";
    echo "Columns: " . implode(', ', $schema->columnNames) . "\n";
} else {
    echo "Table 'menu' NOT FOUND.\n";
}

echo "\n--- Direct Query Check ---\n";
try {
    $cols = Yii::$app->db->createCommand("
        SELECT column_name 
        FROM information_schema.columns 
        WHERE table_name = 'menu';
    ")->queryColumn();
    echo "Real DB columns: " . implode(', ', $cols) . "\n";
} catch (\Exception $e) {
    echo "Error querying information_schema: " . $e->getMessage();
}
