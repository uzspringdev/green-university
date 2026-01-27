<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Announcements');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="announcement-index container py-5">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p><?= Yii::t('app', 'Stay updated with our latest announcements and important information from Green University.') ?>
        </p>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_announcement_item',
        'layout' => '<div class="row g-4">{items}</div><div class="mt-5">{pager}</div>',
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'options' => ['class' => 'pagination mt-5'],
            'linkOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
        ]
    ]) ?>
</div>