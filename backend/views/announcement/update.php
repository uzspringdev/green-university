<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Announcement $model */
/** @var common\models\Language[] $languages */

$this->title = 'Update Announcement: ' . $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->slug, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="announcement-update">
    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>
</div>