<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Tabs;

/** @var yii\web\View $this */
/** @var common\models\News $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $languages */
/** @var array $categories */
?>

<div class="news-form mt-3">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'options' => ['class' => 'mb-4'],
            'labelOptions' => ['class' => 'fw-bold text-muted small text-uppercase mb-2'],
        ],
    ]); ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Content & Translations</h5>
                </div>
                <div class="card-body">
                    <?php
                    $items = [];
                    foreach ($languages as $language) {
                        $translation = \common\models\NewsTranslation::findOne([
                            'news_id' => $model->id,
                            'language_id' => $language->id
                        ]);

                        $items[] = [
                            'label' => $language->name,
                            'content' => '<div class="pt-4">' . $this->render('_form_translation', [
                                'form' => $form,
                                'language' => $language,
                                'translation' => $translation,
                            ]) . '</div>',
                        ];
                    }

                    echo Tabs::widget([
                        'items' => $items,
                        'navType' => 'nav-tabs border-bottom-0',
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Media Settings -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Media & Image</h5>
                </div>
                <div class="card-body">
                    <?php if ($model->image): ?>
                        <div class="mb-3 text-center bg-light rounded p-3 border">
                            <?= Html::img($model->getImageUrl(), ['class' => 'img-fluid rounded shadow-sm', 'style' => 'max-height: 150px;']) ?>
                        </div>
                    <?php endif; ?>
                    <?= $form->field($model, 'imageFile')->fileInput(['class' => 'form-control'])->label('Upload Image') ?>
                </div>
            </div>

            <!-- News Settings -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">General Settings</h5>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'category_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map($categories, 'id', function ($cat) {
                            $trans = $cat->getTranslation('en');
                            return $trans ? $trans->name : $cat->slug;
                        }),
                        ['prompt' => 'Select Category', 'class' => 'form-select']
                    ) ?>

                    <?= $form->field($model, 'status')->dropDownList([
                        \common\models\News::STATUS_DRAFT => 'Draft',
                        \common\models\News::STATUS_PUBLISHED => 'Published',
                    ], ['class' => 'form-select']) ?>

                    <div class="bg-light p-3 rounded mb-4 border d-flex align-items-center justify-content-between">
                        <label class="fw-bold text-muted small text-uppercase mb-0">Feature this post</label>
                        <?= $form->field($model, 'is_featured')->checkbox(['label' => false, 'class' => 'form-check-input ms-2']) ?>
                    </div>

                    <?= $form->field($model, 'published_at')->input('datetime-local', [
                        'class' => 'form-control',
                        'value' => $model->published_at ? date('Y-m-d\TH:i', $model->published_at) : date('Y-m-d\TH:i')
                    ]) ?>

                    <hr class="my-4 opacity-10">

                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'news-article-slug', 'class' => 'form-control bg-light'])->label('URL Slug') ?>
                </div>
            </div>

            <!-- Submit Actions -->
            <div class="card border-0 shadow-sm mb-4 bg-light border">
                <div class="card-body">
                    <?= Html::submitButton('<i class="bi bi-check-circle-fill me-1"></i> Save Changes', ['class' => 'btn btn-success w-100 py-3 rounded-pill shadow-sm mb-2']) ?>
                    <?= Html::a('<i class="bi bi-x-circle me-1"></i> Cancel', ['index'], ['class' => 'btn btn-outline-secondary w-100 py-2 rounded-pill']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .news-form .card {
        border-radius: 12px;
    }

    .news-form .form-control,
    .news-form .form-select {
        border-radius: 8px;
        padding: 0.6rem 0.8rem;
        border-color: #e2e8f0;
    }

    .news-form .form-control:focus,
    .news-form .form-select:focus {
        box-shadow: 0 0 0 3px rgba(45, 134, 89, 0.1);
        border-color: #2d8659;
    }

    .news-form .nav-tabs .nav-link {
        border: none;
        font-weight: 600;
        color: #64748b;
        padding: 1rem 1.5rem;
        transition: all 0.2s;
    }

    .news-form .nav-tabs .nav-link.active {
        color: #2d8659;
        background: transparent;
        border-bottom: 3px solid #2d8659;
    }

    .news-form .nav-tabs .nav-link:hover {
        color: #2d8659;
    }
</style>