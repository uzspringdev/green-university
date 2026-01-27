<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Tabs;

/** @var yii\web\View $this */
/** @var common\models\FooterBlock $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Language[] $languages */
?>


<div class="footer-block-form mt-3 text-start">

    <?php $form = ActiveForm::begin(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Define footer block content and unique identifiers</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-outline-secondary rounded-pill px-4']) ?>
            <?= Html::submitButton('<i class="bi bi-check-lg me-1"></i> Save Block', ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Content & Translations</h5>
                </div>
                <div class="card-body p-4">
                    <?php
                    $items = [];
                    foreach ($languages as $language) {
                        $translation = $model->getTranslation($language->code);
                        $title = $translation ? $translation->title : '';
                        $content = $translation ? $translation->content : '';

                        $itemContent = '<div class="form-group mb-3 text-start">';
                        $itemContent .= '<label class="form-label fw-bold small text-muted text-uppercase mb-2">Display Title (' . strtoupper($language->code) . ')</label>';
                        $itemContent .= Html::textInput("FooterBlockTranslation[{$language->id}][title]", $title, [
                            'class' => 'form-control rounded-pill px-3 py-2',
                            'placeholder' => 'Enter title in ' . strtoupper($language->code)
                        ]);
                        $itemContent .= '</div>';

                        $itemContent .= '<div class="form-group mb-0 text-start">';
                        $itemContent .= '<label class="form-label fw-bold small text-muted text-uppercase mb-2">Block Content (' . strtoupper($language->code) . ')</label>';
                        $itemContent .= Html::textarea("FooterBlockTranslation[{$language->id}][content]", $content, [
                            'class' => 'form-control rounded-4 px-3 py-2',
                            'rows' => 10,
                            'placeholder' => 'Enter HTML or text content...'
                        ]);
                        $itemContent .= '</div>';

                        $items[] = [
                            'label' => strtoupper($language->code),
                            'content' => $itemContent,
                            'active' => $language->code === 'uz',
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
                <div class="card-header bg-transparent py-3 border-bottom text-start">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Configuration</h5>
                </div>
                <div class="card-body p-4 text-start">
                    <?= $form->field($model, 'column_position')->dropDownList([
                        1 => 'Column 1 (Left)',
                        2 => 'Column 2 (Center)',
                        3 => 'Column 3 (Right)',
                        4 => 'Column 4 (Far Right)',
                    ], ['class' => 'form-select rounded-pill']) ?>

                    <?= $form->field($model, 'sort_order')->textInput([
                        'type' => 'number',
                        'class' => 'form-control rounded-pill',
                        'placeholder' => '0'
                    ])->hint('Lower numbers appear first') ?>

                    <?= $form->field($model, 'status')->dropDownList([
                        \common\models\FooterBlock::STATUS_ACTIVE => 'Active',
                        \common\models\FooterBlock::STATUS_INACTIVE => 'Inactive',
                    ], ['class' => 'form-select rounded-pill']) ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-light border">
                <div class="card-body p-4 text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-info-circle fs-3 text-primary opacity-50"></i>
                        <h6 class="mb-0 fw-bold text-dark">Developer Note</h6>
                    </div>
                    <p class="small text-muted mb-3">Use <strong>Column Position</strong> to organize footer blocks into
                        columns, and <strong>Sort Order</strong> to control their vertical arrangement.</p>
                    <div class="bg-dark text-white p-2 rounded-3 small font-monospace">
                        FooterBlock::findByColumn(1)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>