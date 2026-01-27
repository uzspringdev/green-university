<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Tabs;

/** @var yii\web\View $this */
/** @var common\models\NewsCategory $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $languages */
?>

<div class="news-category-form mt-3">

    <?php $form = ActiveForm::begin(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Configure category details and translations</p>
        </div>
        <div class="form-group mb-0">
            <?= Html::submitButton('<i class="bi bi-check-lg me-1"></i> Save Category', ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Translations</h5>
                </div>
                <div class="card-body p-4">
                    <?php
                    $items = [];
                    foreach ($languages as $language) {
                        $translation = \common\models\NewsCategoryTranslation::findOne([
                            'category_id' => $model->id,
                            'language_id' => $language->id
                        ]);

                        $items[] = [
                            'label' => $language->name,
                            'content' => $this->render('_form_translation', [
                                'form' => $form,
                                'language' => $language,
                                'translation' => $translation,
                            ]),
                        ];
                    }

                    echo Tabs::widget([
                        'items' => $items,
                        'navType' => 'nav-pills',
                        'options' => ['class' => 'mb-4'],
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Category Settings</h5>
                </div>
                <div class="card-body p-4">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'category-slug-here']) ?>

                    <?= $form->field($model, 'status')->dropDownList([
                        \common\models\NewsCategory::STATUS_ACTIVE => 'Active',
                        \common\models\NewsCategory::STATUS_INACTIVE => 'Inactive',
                    ]) ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-light border">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-lightbulb fs-3 text-warning opacity-50 mb-3 d-block"></i>
                    <p class="small text-muted mb-0">Slug is used in the URL. Ensure it's unique and only contains
                        lowercase letters, numbers, and hyphens.</p>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>