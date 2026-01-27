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
use common\models\MenuItem;
use common\models\MenuItemTranslation;
use common\models\Language;

$transaction = Yii::$app->db->beginTransaction();

try {
    // 1. Create Main Menu
    $menu = Menu::findOne(['code' => 'main-menu']);
    if (!$menu) {
        // Try finding by ID 1 just in case
        $menu = Menu::findOne(1);
        if ($menu) {
            $menu->code = 'main-menu';
            $menu->save();
            echo "Updated existing menu ID 1 to code 'main-menu'.\n";
        } else {
            $menu = new Menu();
            $menu->code = 'main-menu';
            $menu->name = 'Main Menu';
            $menu->location = 1;
            $menu->status = Menu::STATUS_ACTIVE;
            $menu->created_at = time();
            $menu->updated_at = time();
            $menu->save();
            echo "Created new 'main-menu'.\n";
        }
    } else {
        echo "'main-menu' already exists.\n";
    }

    // 2. Clear existing items (optional, but good for reset)
    // MenuItem::deleteAll(['menu_id' => $menu->id]);

    // 3. Add default items if empty
    if ($menu->getMenuItems()->count() == 0) {
        $items = [
            ['title' => 'Home', 'link' => '/site/index', 'sort' => 0],
            ['title' => 'About', 'link' => '/site/about', 'sort' => 1],
            ['title' => 'News', 'link' => '/news/index', 'sort' => 2],
            ['title' => 'Announcements', 'link' => '/announcement/index', 'sort' => 3],
            ['title' => 'Contact', 'link' => '/site/contact', 'sort' => 4],
        ];

        foreach ($items as $data) {
            $item = new MenuItem();
            $item->menu_id = $menu->id;
            $item->url = $data['link'];
            $item->sort_order = $data['sort'];
            $item->status = MenuItem::STATUS_ACTIVE;
            $item->save();

            // Add translations
            $languages = Language::find()->all();
            foreach ($languages as $lang) {
                $trans = new MenuItemTranslation();
                $trans->menu_item_id = $item->id;
                $trans->language_id = $lang->id;
                $trans->title = $data['title']; // Simple fallback
                // In a real app we might want specific translations
                $trans->save();
            }
        }
        echo "Added default menu items.\n";
    } else {
        echo "Menu items already exist.\n";
    }

    $transaction->commit();
    echo "Menu initialization complete.\n";

} catch (\Exception $e) {
    $transaction->rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
