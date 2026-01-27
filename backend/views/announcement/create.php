<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Announcement $model */
/** @var common\models\Language[] $languages */

$this->title = 'Create Announcement';
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="announcement-create">
    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>
</div>