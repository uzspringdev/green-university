<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');

// Dynamic frontend URL alias
if (php_sapi_name() !== 'cli' && isset($_SERVER['SCRIPT_NAME'])) {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    // We assume backend is at /backend/web. We want to go to /frontend/web.
    // Replace '/backend/web' with '/frontend/web' in the path.
    // Using str_replace on current script path (e.g. /myproject/backend/web/index.php)
    // First get the base directory of the script
    $requestUri = dirname($scriptName); // e.g. /myproject/backend/web

    // Check if we are in backend
    if (strpos($requestUri, '/backend/web') !== false) {
        $frontendUrl = str_replace('/backend/web', '/frontend/web', $requestUri);
    } else {
        // Fallback for non-standard structures, assuming standard relative position
        $frontendUrl = '/frontend/web';
    }
} else {
    $frontendUrl = '/frontend/web';
}

Yii::setAlias('@frontendUrl', $frontendUrl);
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
