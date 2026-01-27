<?php

use yii\helpers\Html;

/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Language $language */
/** @var common\models\NewsCategoryTranslation $translation */

$translation = $translation ?? new \common\models\NewsCategoryTranslation();
?>

<div class="mt-3">
    <div class="mb-3">
        <label class="form-label">Name (
            <?= $language->code ?>)
        </label>
        <?= Html::textInput("NewsCategoryTranslation[{$language->id}][name]", $translation->name, ['class' => 'form-control modern-input']) ?>
    </div>
</div>