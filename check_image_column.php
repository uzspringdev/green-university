<?php

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/common/config/bootstrap.php');
require(__DIR__ . '/console/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/common/config/main.php'),
    require(__DIR__ . '/common/config/main-local.php'),
    require(__DIR__ . '/console/config/main.php'),
    require(__DIR__ . '/console/config/main-local.php')
);

$application = new yii\console\Application($config);

// Check if image column exists
$schema = Yii::$app->db->getTableSchema('announcement');
$columns = array_keys($schema->columns);

echo "Columns in announcement table:\n";
print_r($columns);

if (in_array('image', $columns)) {
    echo "\n✓ Image column EXISTS\n";
} else {
    echo "\n✗ Image column DOES NOT EXIST\n";
}
