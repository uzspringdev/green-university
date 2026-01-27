<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Tabs;

?>

<div class="slider-form mt-3">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Create and manage homepage hero carousel slides</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-outline-secondary rounded-pill px-4']) ?>
            <?= Html::submitButton('<i class="bi bi-check-lg me-1"></i> Save Slider', ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Slide Content</h5>
                </div>
                <div class="card-body p-4">
                    <?php
                    $items = [];
                    foreach ($languages as $language) {
                        $translation = \common\models\SliderTranslation::findOne([
                            'slider_id' => $model->id,
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
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Image & Media</h5>
                </div>
                <div class="card-body p-4">
                    <?= $form->field($model, 'imageFile', [
                        'template' => '{label}<div class="input-group mb-3">{input}</div>{error}{hint}'
                    ])->fileInput(['class' => 'form-control rounded-pill-start']) ?>

                    <?php if ($model->image): ?>
                        <div class="mb-3 p-2 bg-light rounded border text-center">
                            <?= Html::img($model->getImageUrl(), ['class' => 'img-fluid rounded', 'style' => 'max-height: 150px;']) ?>
                            <div class="small text-muted mt-2">Current Image</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Configuration</h5>
                </div>
                <div class="card-body p-4">
                    <?= $form->field($model, 'link_url')->textInput(['maxlength' => true, 'placeholder' => '/page/about', 'class' => 'form-control rounded-pill']) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'sort_order')->input('number', ['class' => 'form-control rounded-pill']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList([
                                \common\models\Slider::STATUS_ACTIVE => 'Active',
                                \common\models\Slider::STATUS_INACTIVE => 'Inactive',
                            ], ['class' => 'form-select rounded-pill']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>