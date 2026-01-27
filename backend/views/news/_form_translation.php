<?php

use yii\helpers\Html;

/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Language $language */
/** @var common\models\NewsTranslation|null $translation */

$title = $translation ? $translation->title : '';
$summary = $translation ? $translation->summary : '';
$content = $translation ? $translation->content : '';
?>

<div class="translation-form">
    <div class="form-group">
        <label>Title</label>
        <?= Html::textInput("NewsTranslation[{$language->id}][title]", $title, [
            'class' => 'form-control',
        ]) ?>
    </div>

    <div class="form-group">
        <label>Summary</label>
        <?= Html::textarea("NewsTranslation[{$language->id}][summary]", $summary, [
            'class' => 'form-control',
            'rows' => 3
        ]) ?>
    </div>

    <div class="form-group">
        <label>Content</label>
        <?= Html::textarea("NewsTranslation[{$language->id}][content]", $content, [
            'class' => 'form-control',
            'rows' => 10
        ]) ?>
    </div>
</div>