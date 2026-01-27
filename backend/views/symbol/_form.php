<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Tabs;

/** @var yii\web\View $this */
/** @var common\models\Symbol $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Language[] $languages */

$this->title = ($model->isNewRecord ? 'Create' : 'Update') . ' Symbol';
$this->params['breadcrumbs'][] = ['label' => 'Symbols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="symbol-form mt-3 text-start">

    <?php $form = ActiveForm::begin(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Define symbol icons, values, and translations</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-outline-secondary rounded-pill px-4']) ?>
            <?= Html::submitButton('<i class="bi bi-check-lg me-1"></i> Save Symbol', ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
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
                        $translation = $model->getTranslation($language->code);
                        $title = $translation ? $translation->title : '';

                        $itemContent = '<div class="form-group mb-0 text-start">';
                        $itemContent .= '<label class="form-label fw-bold small text-muted text-uppercase mb-2">Display Title (' . strtoupper($language->code) . ')</label>';
                        $itemContent .= Html::textInput("SymbolTranslation[{$language->id}][title]", $title, [
                            'class' => 'form-control rounded-pill px-3 py-2',
                            'placeholder' => 'Enter title in ' . strtoupper($language->code)
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

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-3 border-bottom text-start">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Icon & Value</h5>
                </div>
                <div class="card-body p-4 text-start">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $form->field($model, 'icon', [
                                'template' => '{label}<div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-pill-start"><i class="bi bi-app"></i></span>
                                    {input}
                                </div>{error}{hint}'
                            ])->textInput(['maxlength' => true, 'class' => 'form-control border-start-0 rounded-pill-end', 'placeholder' => 'bi bi-star-fill']) ?>
                            <div class="small text-muted mt-1 px-2">Use <a href="https://icons.getbootstrap.com/"
                                    target="_blank">Bootstrap Icons</a> class names</div>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'value', [
                                'template' => '{label}<div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-pill-start"><i class="bi bi-hash"></i></span>
                                    {input}
                                </div>{error}{hint}'
                            ])->textInput(['maxlength' => true, 'class' => 'form-control border-start-0 rounded-pill-end', 'placeholder' => 'e.g. 5000+']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom text-start">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Settings</h5>
                </div>
                <div class="card-body p-4 text-start">
                    <?= $form->field($model, 'sort_order')->input('number', ['class' => 'form-control rounded-pill']) ?>
                    <?= $form->field($model, 'status')->dropDownList([
                        \common\models\Symbol::STATUS_ACTIVE => 'Active',
                        \common\models\Symbol::STATUS_INACTIVE => 'Inactive',
                    ], ['class' => 'form-select rounded-pill']) ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-light border">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-patch-check fs-2 text-primary opacity-50 mb-3 d-block"></i>
                    <h6 class="fw-bold">Preview</h6>
                    <div class="d-flex flex-column align-items-center mt-3 bg-white p-3 rounded-4 shadow-sm">
                        <i class="bi bi-star-fill fs-2 text-primary mb-2"></i>
                        <h4 class="fw-bold mb-1">5000+</h4>
                        <span class="text-muted small">Sample Symbol</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>