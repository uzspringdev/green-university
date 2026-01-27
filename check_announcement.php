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

echo "--- Schema Info for 'announcement' ---\n";
$schema = Yii::$app->db->getTableSchema('announcement');
if ($schema) {
    echo "Columns: " . implode(', ', $schema->columnNames) . "\n";
} else {
    echo "Table 'announcement' NOT FOUND.\n";
}

echo "\n--- Direct Query Check ---\n";
try {
    $cols = Yii::$app->db->createCommand("
        SELECT column_name 
        FROM information_schema.columns 
        WHERE table_name = 'announcement';
    ")->queryColumn();
    echo "Real DB columns: " . implode(', ', $cols) . "\n";
} catch (\Exception $e) {
    echo "Error querying information_schema: " . $e->getMessage();
}
