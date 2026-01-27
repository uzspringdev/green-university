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

// Add image column to announcement table
try {
    Yii::$app->db->createCommand()
        ->addColumn('announcement', 'image', 'VARCHAR(255) NULL')
        ->execute();

    echo "✓ Successfully added 'image' column to announcement table\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

// Verify
$schema = Yii::$app->db->getTableSchema('announcement', true); // true to refresh cache
$columns = array_keys($schema->columns);

if (in_array('image', $columns)) {
    echo "✓ Verified: Image column now exists\n";
} else {
    echo "✗ Error: Image column still does not exist\n";
}
