<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Application $model */

$this->title = Yii::t('app', 'Undergraduate Admission');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="application-form container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="page-header mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3"><?= Html::encode($this->title) ?></h1>
                <p class="lead text-muted">
                    <?= Yii::t('app', 'Take the first step towards a sustainable future. Fill out your details below to start your application process.') ?>
                </p>
            </div>

            <div class="card border-0 shadow-md rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center gap-3 mb-5 pb-3 border-bottom">
                        <div class="bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-person-lines-fill fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-0"><?= Yii::t('app', 'Personal Information') ?></h4>
                            <p class="small text-muted mb-0">
                                <?= Yii::t('app', 'Please provide your basic contact details.') ?>
                            </p>
                        </div>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'id' => 'application-form',
                        'options' => ['class' => 'needs-validation', 'enctype' => 'multipart/form-data'],
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                        ],
                    ]); ?>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <?= $form->field($model, 'first_name')->textInput(['placeholder' => Yii::t('app', 'e.g. John')]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'last_name')->textInput(['placeholder' => Yii::t('app', 'e.g. Doe')]) ?>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['type' => 'email', 'placeholder' => 'john.doe@example.com']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone')->textInput(['placeholder' => '+998 __ ___ __ __']) ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'program')->textInput(['placeholder' => Yii::t('app', 'Select your desired course of study')]) ?>
                    </div>

                    <div class="mb-5">
                        <?= $form->field($model, 'message')->textarea([
                            'rows' => 5,
                            'placeholder' => Yii::t('app', 'Briefly tell us about your academic goals and interest in Green University.')
                        ]) ?>
                    </div>

                    <div class="mb-5">
                        <?= $form->field($model, 'uploadFile')->fileInput(['class' => 'form-control']) ?>
                        <div class="form-text text-muted">
                            <?= Yii::t('app', 'Max size: 50MB. Allowed formats: PDF, DOC, DOCX, JPG, PNG, ZIP.') ?>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <?= Html::submitButton(
                            Yii::t('app', 'Submit My Application') . ' <i class="bi bi-arrow-right ms-2 font-bold"></i>',
                            ['class' => 'btn btn-primary btn-lg px-5 shadow-sm']
                        ) ?>
                        <p class="small text-muted mt-4">
                            <i class="bi bi-info-circle me-1"></i>
                            <?= Yii::t('app', 'By submitting, you agree to our processing of your admission data.') ?>
                        </p>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="row mt-5 g-4 text-center">
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-shield-lock fs-2 text-secondary mb-3 d-block"></i>
                        <h6 class="fw-bold"><?= Yii::t('app', 'Secure Data') ?></h6>
                        <p class="small text-muted mb-0">
                            <?= Yii::t('app', 'Your information is protected by industry standard encryption.') ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 border-start border-end">
                    <div class="p-3">
                        <i class="bi bi-clock-history fs-2 text-secondary mb-3 d-block"></i>
                        <h6 class="fw-bold"><?= Yii::t('app', 'Quick Review') ?></h6>
                        <p class="small text-muted mb-0">
                            <?= Yii::t('app', 'Our admissions board reviews applications within 5-7 business days.') ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-chat-dots fs-2 text-secondary mb-3 d-block"></i>
                        <h6 class="fw-bold"><?= Yii::t('app', 'Support') ?></h6>
                        <p class="small text-muted mb-0">
                            <?= Yii::t('app', 'Need help? Contact our support team for any queries.') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>