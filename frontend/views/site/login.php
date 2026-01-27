<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::t('app', 'Student Login');
?>
<div class="site-login container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4 border-0">
                    <h3 class="fw-bold mb-0"><?= Html::encode($this->title) ?></h3>
                    <p class="mb-0 opacity-75 small"><?= Yii::t('app', 'Welcome back to your dashboard') ?></p>
                </div>
                <div class="card-body p-4 p-md-5">

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-medium text-dark'],
                            'inputOptions' => ['class' => 'form-control form-control-lg'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <div class="mb-3">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Enter your username']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter your password']) ?>
                        <div class="d-flex justify-content-end mt-1">
                            <a href="<?= \yii\helpers\Url::to(['site/request-password-reset']) ?>"
                                class="small text-muted text-decoration-none"><?= Yii::t('app', 'Forgot Password?') ?></a>
                        </div>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"form-check custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ]) ?>
                    </div>

                    <div class="d-grid gap-2">
                        <?= Html::submitButton(Yii::t('app', 'Sign In'), ['class' => 'btn btn-primary btn-lg shadow-sm font-weight-bold', 'name' => 'login-button']) ?>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <div class="text-center text-muted">
                        <?= Yii::t('app', 'Don\'t have an account?') ?>
                        <a href="<?= \yii\helpers\Url::to(['site/signup']) ?>"
                            class="fw-bold text-primary text-decoration-none"><?= Yii::t('app', 'Register Now') ?></a>
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