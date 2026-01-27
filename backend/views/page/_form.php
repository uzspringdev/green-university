<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Tabs;

?>

<div class="page-form mt-3">

    <?php $form = ActiveForm::begin(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Edit dynamic page content and properties</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-outline-secondary rounded-pill px-4']) ?>
            <?= Html::submitButton('<i class="bi bi-check-lg me-1"></i> Save Page', ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Page Content</h5>
                </div>
                <div class="card-body p-4">
                    <?php
                    $items = [];
                    foreach ($languages as $language) {
                        $translation = \common\models\PageTranslation::findOne([
                            'page_id' => $model->id,
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
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Page Settings</h5>
                </div>
                <div class="card-body p-4">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'about-us']) ?>

                    <?= $form->field($model, 'status')->dropDownList([
                        \common\models\Page::STATUS_ACTIVE => 'Active',
                        \common\models\Page::STATUS_INACTIVE => 'Inactive',
                    ]) ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-light border">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-info-circle fs-3 text-primary opacity-50 mb-3 d-block"></i>
                    <p class="small text-muted mb-0">The slug determines the page URL (e.g.,
                        example.com/page/<strong>about-us</strong>). Choose a clear and SEO-friendly name.</p>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>