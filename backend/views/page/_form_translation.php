<?php

use yii\helpers\Html;

$title = $translation ? $translation->title : '';
$content = $translation ? $translation->content : '';
$metaDescription = $translation ? $translation->meta_description : '';
$metaKeywords = $translation ? $translation->meta_keywords : '';
?>

<div class="translation-form">
    <div class="form-group">
        <label>Title</label>
        <?= Html::textInput("PageTranslation[{$language->id}][title]", $title, [
            'class' => 'form-control',
        ]) ?>
    </div>

    <div class="form-group">
        <label>Content</label>
        <?= Html::textarea("PageTranslation[{$language->id}][content]", $content, [
            'class' => 'form-control',
            'rows' => 15
        ]) ?>
    </div>

    <div class="form-group">
        <label>Meta Description</label>
        <?= Html::textarea("PageTranslation[{$language->id}][meta_description]", $metaDescription, [
            'class' => 'form-control',
            'rows' => 2
        ]) ?>
    </div>

    <div class="form-group">
        <label>Meta Keywords</label>
        <?= Html::textInput("PageTranslation[{$language->id}][meta_keywords]", $metaKeywords, [
            'class' => 'form-control'
        ]) ?>
    </div>
</div>