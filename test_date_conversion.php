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

// Test date conversion
$testDates = [
    '2026-01-19T12:26',
    '01/19/2026 12:26 AM',
    '1737277560',
    1737277560,
];

echo "Testing date conversions:\n\n";
foreach ($testDates as $date) {
    echo "Input: " . var_export($date, true) . "\n";
    echo "is_numeric: " . (is_numeric($date) ? 'true' : 'false') . "\n";

    if (!is_numeric($date)) {
        $timestamp = strtotime($date);
        echo "strtotime result: " . var_export($timestamp, true) . "\n";
        if ($timestamp) {
            echo "Formatted: " . date('Y-m-d H:i:s', $timestamp) . "\n";
        }
    }
    echo "\n";
}
