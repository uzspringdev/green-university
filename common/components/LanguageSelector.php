<?php

namespace common\components;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Language component to handle multi-language support
 */
class LanguageSelector implements BootstrapInterface
{
    /**
     * Bootstrap method to set language from cookie/session
     */
    public function bootstrap($app)
    {
        // Try to get language from cookie
        $cookieLanguage = Yii::$app->request->cookies->getValue('language');

        // Try to get language from session
        $sessionLanguage = Yii::$app->session->get('language');

        // Try to get language from GET parameter
        $getLanguage = Yii::$app->request->get('lang');

        // Set language priority: GET > Session > Cookie > Default
        if ($getLanguage && in_array($getLanguage, ['uz', 'en', 'ru'])) {
            Yii::$app->language = $getLanguage;
        } elseif ($sessionLanguage) {
            Yii::$app->language = $sessionLanguage;
        } elseif ($cookieLanguage) {
            Yii::$app->language = $cookieLanguage;
        } else {
            Yii::$app->language = 'uz'; // Default language
        }
    }
}
