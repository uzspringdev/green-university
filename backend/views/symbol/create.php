<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Symbol $model */
/** @var common\models\Language[] $languages */

$this->title = 'Create Symbol';
$this->params['breadcrumbs'][] = ['label' => 'Symbols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="symbol-create">
    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>
</div>