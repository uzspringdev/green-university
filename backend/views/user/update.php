<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Modify Staff Authority: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Staff Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modify Authority';
?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>