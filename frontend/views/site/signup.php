<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::t('app', 'Create Student Account');
?>
<div class="site-signup container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4 border-0">
                    <h3 class="fw-bold mb-0"><?= Html::encode($this->title) ?></h3>
                    <p class="mb-0 opacity-75 small"><?= Yii::t('app', 'Join Green University Admission Portal') ?></p>
                </div>
                <div class="card-body p-4 p-md-5">

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-signup',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-medium text-dark'],
                            'inputOptions' => ['class' => 'form-control form-control-lg'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $form->field($model, 'first_name')->textInput(['autofocus' => true, 'placeholder' => 'First Name']) ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name']) ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Choose a username']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'email')->input('email', ['placeholder' => 'name@example.com']) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Create a strong password']) ?>
                    </div>

                    <div class="d-grid gap-2">
                        <?= Html::submitButton(Yii::t('app', 'Register Account'), ['class' => 'btn btn-primary btn-lg shadow-sm font-weight-bold', 'name' => 'signup-button']) ?>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <div class="text-center text-muted">
                        <?= Yii::t('app', 'Already have an account?') ?>
                        <a href="<?= \yii\helpers\Url::to(['site/login']) ?>"
                            class="fw-bold text-primary text-decoration-none"><?= Yii::t('app', 'Login here') ?></a>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="text-center mt-4 text-muted small">
                &copy; <?= date('Y') ?> Green University. <?= Yii::t('app', 'All rights reserved.') ?>
            </div>
        </div>
    </div>
</div>