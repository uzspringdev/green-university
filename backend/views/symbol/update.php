<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Symbol $model */
/** @var common\models\Language[] $languages */

$this->title = 'Update Symbol: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Symbols', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Symbol #' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="symbol-update">
    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>
</div>