<?php

use yii\helpers\Html;

$title = $translation ? $translation->title : '';
$subtitle = $translation ? $translation->subtitle : '';
$linkText = $translation ? $translation->link_text : '';
?>

<div class="translation-form">
    <div class="form-group">
        <label>Title</label>
        <?= Html::textInput("SliderTranslation[{$language->id}][title]", $title, [
            'class' => 'form-control',
            'placeholder' => 'Main heading text'
        ]) ?>
    </div>

    <div class="form-group">
        <label>Subtitle</label>
        <?= Html::textarea("SliderTranslation[{$language->id}][subtitle]", $subtitle, [
            'class' => 'form-control',
            'rows' => 2,
            'placeholder' => 'Secondary text'
        ]) ?>
    </div>

    <div class="form-group">
        <label>Link Text (Button)</label>
        <?= Html::textInput("SliderTranslation[{$language->id}][link_text]", $translation ? $translation->link_text : '', [
            'class' => 'form-control',
            'placeholder' => 'Learn More, Apply Now, etc.'
        ]) ?>
    </div>
</div>