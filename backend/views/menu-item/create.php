<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\MenuItem $model */

$this->title = 'Create Menu Item';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['/menu/index']];
if ($model->menu) {
    $this->params['breadcrumbs'][] = ['label' => $model->menu->name, 'url' => ['/menu/view', 'id' => $model->menu_id]];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-create">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>