<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\MenuItem $model */

$this->title = 'Update Menu Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['/menu/index']];
if ($model->menu) {
    $this->params['breadcrumbs'][] = ['label' => $model->menu->name, 'url' => ['/menu/view', 'id' => $model->menu_id]];
}
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-item-update">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>