<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = Yii::t('app', 'About Us');
// Breadcrumbs can be removed here if title is sufficient in Hero, or kept minimal.
// $this->params['breadcrumbs'][] = $this->title; 
?>

<!-- Modern Hero -->
<div class="about-hero-modern">
    <div class="container text-center">
        <h1><?= Yii::t('app', 'About Green University') ?></h1>
        <p class="lead">
            <?= Yii::t('app', 'Leading the way in innovative education and research excellence in Uzbekistan') ?></p>
    </div>
</div>

<div class="container mb-5">
    <!-- Mission & Vision Cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="bi bi-bullseye"></i>
                </div>
                <h3><?= Yii::t('app', 'Our Mission') ?></h3>
                <p class="text-muted mb-0">
                    <?= Yii::t('app', 'To provide world-class education and foster innovation, preparing students to become leaders and global citizens who contribute positively to society and the economy.') ?>
                </p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="bi bi-eye"></i>
                </div>
                <h3><?= Yii::t('app', 'Our Vision') ?></h3>
                <p class="text-muted mb-0">
                    <?= Yii::t('app', 'To be the leading university in Central Asia, recognized internationally for academic excellence, groundbreaking research, and transformative impact on communities.') ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modern Stats Section -->
<div class="stats-section mb-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <span class="stat-number">15k+</span>
                    <span class="stat-label"><?= Yii::t('app', 'Students') ?></span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label"><?= Yii::t('app', 'Faculty Members') ?></span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <span class="stat-number">50+</span>
                    <span class="stat-label"><?= Yii::t('app', 'Study Programs') ?></span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <span class="stat-number">30+</span>
                    <span class="stat-label"><?= Yii::t('app', 'Partner Universities') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Why Choose Us -->
    <div class="text-center mb-5">
        <h2 class="section-title"><?= Yii::t('app', 'Why Choose Green University?') ?></h2>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            <?= Yii::t('app', 'We are dedicated to shaping the future through sustainable education and global partnerships.') ?>
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card-modern">
                <div class="icon-wrapper">
                    <i class="bi bi-mortarboard"></i>
                </div>
                <h3><?= Yii::t('app', 'Academic Excellence') ?></h3>
                <p class="text-muted">
                    <?= Yii::t('app', 'Our rigorous academic programs are designed by industry experts and delivered by experienced faculty members.') ?>
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card-modern">
                <div class="icon-wrapper">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <h3><?= Yii::t('app', 'Research & Innovation') ?></h3>
                <p class="text-muted">
                    <?= Yii::t('app', 'State-of-the-art laboratories and research centers foster groundbreaking discoveries and innovations.') ?>
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card-modern">
                <div class="icon-wrapper">
                    <i class="bi bi-globe"></i>
                </div>
                <h3><?= Yii::t('app', 'Global Perspective') ?></h3>
                <p class="text-muted">
                    <?= Yii::t('app', 'International partnerships and exchange programs provide students with global learning opportunities.') ?>
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card-modern">
                <div class="icon-wrapper">
                    <i class="bi bi-briefcase"></i>
                </div>
                <h3><?= Yii::t('app', 'Career Development') ?></h3>
                <p class="text-muted">
                    <?= Yii::t('app', 'Dedicated career services and industry connections ensure our graduates are ready for the job market.') ?>
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card-modern">
                <div class="icon-wrapper">
                    <i class="bi bi-building"></i>
                </div>
                <h3><?= Yii::t('app', 'Modern Facilities') ?></h3>
                <p class="text-muted">
                    <?= Yii::t('app', 'Campus features modern classrooms, libraries, sports facilities, and student accommodations.') ?>
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card-modern">
                <div class="icon-wrapper">
                    <i class="bi bi-heart"></i>
                </div>
                <h3><?= Yii::t('app', 'Student Support') ?></h3>
                <p class="text-muted">
                    <?= Yii::t('app', 'Comprehensive support services including academic advising, counseling, and student activities.') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- History -->
    <div class="row justify-content-center mt-5 pt-5">
        <div class="col-lg-8">
            <div class="ps-4 border-start border-3 border-light">
                <h2 class="mb-4 text-primary"><?= Yii::t('app', 'Our History') ?></h2>
                <div class="history-item">
                    <h5 class="fw-bold">2005</h5>
                    <p class="text-muted">
                        <?= Yii::t('app', 'Founded in 2005, Green University has grown from a small institution with just 500 students to become one of the leading universities in Uzbekistan.') ?>
                    </p>
                </div>
                <div class="history-item">
                    <h5 class="fw-bold"><?= Yii::t('app', 'Today') ?></h5>
                    <p class="text-muted">
                        <?= Yii::t('app', 'Over the years, we have continuously adapted our programs to meet the evolving needs of society and industry, ensuring our graduates are equipped with the knowledge, skills, and competencies needed to succeed in a rapidly changing world.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>