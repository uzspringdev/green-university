<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Contact Us');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .contact-page {
        padding: 0;
    }

    .contact-hero {
        background: linear-gradient(135deg, #1f5d3f 0%, #2d8659 100%);
        color: white;
        padding: 5rem 0 3rem;
        text-align: center;
    }

    .contact-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .contact-hero p {
        font-size: 1.3rem;
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto;
    }

    .contact-info-section {
        padding: 4rem 0;
        background: #f9fafb;
    }

    .contact-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        text-align: center;
        box-shadow: 0 2px 12px rgba(45, 134, 89, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid transparent;
    }

    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(45, 134, 89, 0.18);
        border-color: rgba(45, 134, 89, 0.2);
    }

    .contact-card-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2d8659 0%, #1f5d3f 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: white;
    }

    .contact-card h3 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
    }

    .contact-card p {
        color: #6b7280;
        font-size: 1.05rem;
        line-height: 1.6;
        margin-bottom: 0.5rem;
    }

    .contact-card a {
        color: #2d8659;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .contact-card a:hover {
        color: #1f5d3f;
    }

    .contact-form-section {
        padding: 4rem 0;
    }

    .contact-form-wrapper {
        background: white;
        border-radius: 16px;
        padding: 3rem;
        box-shadow: 0 2px 12px rgba(45, 134, 89, 0.08);
    }

    .contact-form-wrapper h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
    }

    .contact-form-wrapper .subtitle {
        color: #6b7280;
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2d8659;
        box-shadow: 0 0 0 4px rgba(45, 134, 89, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .btn-submit {
        background: #2d8659;
        color: white;
        border: none;
        padding: 1rem 3rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-submit:hover {
        background: #1f5d3f;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(45, 134, 89, 0.3);
    }

    .map-section {
        height: 400px;
        background: #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    }

    .map-section iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .social-connect {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 2px 12px rgba(45, 134, 89, 0.08);
        text-align: center;
    }

    .social-connect h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }

    .social-icons-large {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .social-icon-large {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9fafb;
        color: #6b7280;
        font-size: 1.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
    }

    .social-icon-large:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .social-icon-large.facebook:hover {
        background: #1877f2;
        color: white;
        border-color: #1877f2;
    }

    .social-icon-large.instagram:hover {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        color: white;
        border-color: #bc1888;
    }

    .social-icon-large.telegram:hover {
        background: #0088cc;
        color: white;
        border-color: #0088cc;
    }

    .social-icon-large.youtube:hover {
        background: #ff0000;
        color: white;
        border-color: #ff0000;
    }
</style>

<div class="contact-page">
    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="container">
            <h1><?= Html::encode($this->title) ?></h1>
            <p><?= Yii::t('app', 'We\'d love to hear from you. Get in touch with us for any inquiries or questions.') ?>
            </p>
        </div>
    </div>

    <!-- Contact Info Cards -->
    <div class="contact-info-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-card">
                        <div class="contact-card-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h3><?= Yii::t('app', 'Address') ?></h3>
                        <p>Tashkent, Uzbekistan</p>
                        <p>Yunusobod district</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-card">
                        <div class="contact-card-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h3><?= Yii::t('app', 'Phone') ?></h3>
                        <p><a href="tel:+998555120077">+998 55 512 00 77</a></p>
                        <p><a href="tel:+998712345678">+998 71 234 56 78</a></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-card">
                        <div class="contact-card-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <h3><?= Yii::t('app', 'Email') ?></h3>
                        <p><a href="mailto:info@greenuniversity.uz">info@greenuniversity.uz</a></p>
                        <p><a href="mailto:admission@greenuniversity.uz">admission@greenuniversity.uz</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form & Map Section -->
    <div class="contact-form-section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="contact-form-wrapper">
                        <h2><?= Yii::t('app', 'Send us a Message') ?></h2>
                        <p class="subtitle">
                            <?= Yii::t('app', 'Fill out the form below and we\'ll get back to you as soon as possible.') ?>
                        </p>

                        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                        <?= $form->field($model, 'name')->textInput([
                            'autofocus' => true,
                            'placeholder' => Yii::t('app', 'Your full name')
                        ]) ?>

                        <?= $form->field($model, 'email')->textInput([
                            'placeholder' => Yii::t('app', 'your.email@example.com')
                        ]) ?>

                        <?= $form->field($model, 'subject')->textInput([
                            'placeholder' => Yii::t('app', 'What is this about?')
                        ]) ?>

                        <?= $form->field($model, 'body')->textarea([
                            'rows' => 6,
                            'placeholder' => Yii::t('app', 'Write your message here...')
                        ]) ?>

                        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                            'template' => '<div class="row g-3"><div class="col-lg-5">{image}</div><div class="col-lg-7">{input}</div></div>',
                        ]) ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Send Message'), ['class' => 'btn btn-submit', 'name' => 'contact-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="map-section mb-4">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2996.2589579018787!2d69.27503931544395!3d41.31151797927107!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8b0cc379e9c3%3A0xa5a9323b4aa5cb98!2sTashkent%2C%20Uzbekistan!5e0!3m2!1sen!2s!4v1642000000000!5m2!1sen!2s"
                            allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <div class="social-connect">
                        <h3><?= Yii::t('app', 'Connect With Us') ?></h3>
                        <div class="social-icons-large">
                            <a href="#" class="social-icon-large facebook" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-icon-large instagram" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-icon-large telegram" title="Telegram">
                                <i class="bi bi-telegram"></i>
                            </a>
                            <a href="#" class="social-icon-large youtube" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>