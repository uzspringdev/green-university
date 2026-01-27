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

echo "Dropping unwanted columns from announcement table...\n\n";

try {
    // Drop start_date
    echo "Dropping start_date column...";
    Yii::$app->db->createCommand()->dropColumn('announcement', 'start_date')->execute();
    echo " ✓\n";
} catch (Exception $e) {
    echo " Error: " . $e->getMessage() . "\n";
}

try {
    // Drop end_date
    echo "Dropping end_date column...";
    Yii::$app->db->createCommand()->dropColumn('announcement', 'end_date')->execute();
    echo " ✓\n";
} catch (Exception $e) {
    echo " Error: " . $e->getMessage() . "\n";
}

try {
    // Drop announcement_type
    echo "Dropping announcement_type column...";
    Yii::$app->db->createCommand()->dropColumn('announcement', 'announcement_type')->execute();
    echo " ✓\n";
} catch (Exception $e) {
    echo " Error: " . $e->getMessage() . "\n";
}

// Verify
echo "\nVerifying columns...\n";
$schema = Yii::$app->db->getTableSchema('announcement', true); // true to refresh cache
$columns = array_keys($schema->columns);

echo "Current columns: " . implode(', ', $columns) . "\n";

if (!in_array('start_date', $columns) && !in_array('end_date', $columns) && !in_array('announcement_type', $columns)) {
    echo "\n✓ All unwanted columns have been removed successfully!\n";
} else {
    echo "\n✗ Some columns still exist\n";
}
