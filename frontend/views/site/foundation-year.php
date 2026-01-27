<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Foundation Year Programme');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .foundation-page {
        background: #ffffff;
    }

    /* Hero Banner - Similar to official site */
    .page-hero {
        background: linear-gradient(135deg, rgba(31, 93, 63, 0.95) 0%, rgba(45, 134, 89, 0.9) 100%),
            url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%231f5d3f" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,165.3C384,171,480,149,576,133.3C672,117,768,107,864,122.7C960,139,1056,181,1152,181.3C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: cover;
        background-position: center;
        padding: 6rem 0 4rem;
        position: relative;
        color: white;
        margin-bottom: 0;
    }

    .page-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
    }

    .page-hero .container {
        position: relative;
        z-index: 1;
    }

    .page-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .page-hero .lead {
        font-size: 1.25rem;
        line-height: 1.8;
        max-width: 900px;
        opacity: 0.95;
        font-weight: 400;
    }

    /* Content Sections */
    .content-section {
        padding: 4rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .content-section:last-child {
        border-bottom: none;
    }

    .content-section.bg-light {
        background: #f9fafb;
    }

    .section-heading {
        font-size: 2.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 2rem;
        position: relative;
        padding-bottom: 1rem;
    }

    .section-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: #2d8659;
        border-radius: 2px;
    }

    .section-intro {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #4b5563;
        margin-bottom: 2.5rem;
    }

    /* List Styles - Official site inspired */
    .feature-list {
        list-style: none;
        padding: 0;
        margin: 2rem 0;
    }

    .feature-list li {
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        background: white;
        border-left: 4px solid #2d8659;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        font-size: 1.05rem;
        line-height: 1.6;
        color: #374151;
    }

    .feature-list li:hover {
        box-shadow: 0 4px 12px rgba(45, 134, 89, 0.15);
        transform: translateX(8px);
    }

    .feature-list li::before {
        content: '→';
        color: #2d8659;
        font-weight: bold;
        margin-right: 1rem;
        font-size: 1.2rem;
    }

    /* Module Cards Grid - Official style */
    .modules-section {
        background: #f9fafb;
        padding: 4rem 0;
    }

    .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2.5rem;
    }

    .module-item {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }

    .module-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #2d8659 0%, #1f5d3f 100%);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .module-item:hover::before {
        transform: scaleX(1);
    }

    .module-item:hover {
        box-shadow: 0 8px 24px rgba(45, 134, 89, 0.12);
        transform: translateY(-4px);
        border-color: #2d8659;
    }

    .module-number {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #2d8659 0%, #1f5d3f 100%);
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .module-item h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .module-item p {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    /* Info Box - Official style */
    .info-box {
        background: linear-gradient(135deg, #e8f5f0 0%, #f0f9f5 100%);
        border: 2px solid #2d8659;
        border-radius: 12px;
        padding: 2rem 2.5rem;
        margin: 2.5rem 0;
        position: relative;
    }

    .info-box::before {
        content: 'ℹ️';
        position: absolute;
        top: -20px;
        left: 30px;
        background: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border: 2px solid #2d8659;
    }

    .info-box p {
        color: #1a1a1a;
        font-size: 1.05rem;
        line-height: 1.7;
        margin: 0;
        font-weight: 500;
    }

    /* Stats Section */
    .stats-highlight {
        background: white;
        padding: 3rem;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        margin: 2rem 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        text-align: center;
    }

    .stat-item {
        padding: 1.5rem;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        color: #2d8659;
        display: block;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    /* CTA Banner */
    .cta-banner {
        background: linear-gradient(135deg, #1f5d3f 0%, #2d8659 100%);
        color: white;
        padding: 4rem 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" d="M0,96L48,112C96,128,192,160,288,165.3C384,171,480,149,576,133.3C672,117,768,107,864,122.7C960,139,1056,181,1152,181.3C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        opacity: 0.3;
    }

    .cta-banner .container {
        position: relative;
        z-index: 1;
    }

    .cta-banner h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-banner p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    .btn-cta {
        background: white;
        color: #2d8659;
        padding: 1rem 3rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        color: #1f5d3f;
    }
</style>

<div class="foundation-page">
    <!-- Hero Section -->
    <div class="page-hero">
        <div class="container">
            <h1><?= Yii::t('app', 'Foundation Year Programme') ?></h1>
            <p class="lead">
                <?= Yii::t('app', 'A comprehensive one-year programme designed to prepare students for undergraduate studies at Green University. Develop essential academic skills, environmental knowledge, and English language proficiency.') ?>
            </p>
        </div>
    </div>

    <!-- Overview Section -->
    <div class="content-section">
        <div class="container">
            <h2 class="section-heading"><?= Yii::t('app', 'Programme Overview') ?></h2>
            <p class="section-intro">
                <?= Yii::t('app', 'The Foundation Year is a day programme that can be completed within one academic year. It consists of 6 modules, 3 modules per semester. All modules are taught in English and form the essential first year of Bachelor\'s programmes at Green University.') ?>
            </p>

            <div class="stats-highlight">
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">1</span>
                        <span class="stat-label"><?= Yii::t('app', 'Year') ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">6</span>
                        <span class="stat-label"><?= Yii::t('app', 'Modules') ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">2</span>
                        <span class="stat-label"><?= Yii::t('app', 'Semesters') ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label"><?= Yii::t('app', 'English') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Purpose Section -->
    <div class="content-section bg-light">
        <div class="container">
            <h2 class="section-heading"><?= Yii::t('app', 'Programme Purpose') ?></h2>
            <p class="section-intro">
                <?= Yii::t('app', 'The Foundation Year programme is designed to equip students with the fundamental knowledge and skills necessary for success in environmental studies and beyond.') ?>
            </p>

            <ul class="feature-list">
                <li><?= Yii::t('app', 'Provide a flexibly structured program of study to improve English language skills and communication skills together with soft skills') ?>
                </li>
                <li><?= Yii::t('app', 'Establish a sound knowledge base in environment studies and introduce fundamental environmental concepts') ?>
                </li>
                <li><?= Yii::t('app', 'Encourage the development of a creative attitude, an open mind, and ecology-relevant awareness') ?>
                </li>
                <li><?= Yii::t('app', 'Prepare students for advanced undergraduate studies in environmental management and sustainability') ?>
                </li>
            </ul>
        </div>
    </div>

    <!-- Learning Outcomes Section -->
    <div class="content-section">
        <div class="container">
            <h2 class="section-heading"><?= Yii::t('app', 'Learning Outcomes') ?></h2>
            <p class="section-intro">
                <?= Yii::t('app', 'Upon successful completion of the Foundation Year, students will have developed:') ?>
            </p>

            <ul class="feature-list">
                <li><?= Yii::t('app', 'Proficiency in English language skills, communication skills, and soft skills essential for academic success') ?>
                </li>
                <li><?= Yii::t('app', 'Understanding of basic environmental concepts and sustainability principles') ?>
                </li>
                <li><?= Yii::t('app', 'Strong interest in Environment Management, Environment Protection, and Sustainability') ?>
                </li>
                <li><?= Yii::t('app', 'Ability to apply theoretical knowledge to practical environmental challenges') ?>
                </li>
                <li><?= Yii::t('app', 'Critical thinking and analytical skills for environmental problem-solving') ?>
                </li>
            </ul>

            <div class="info-box">
                <p><?= Yii::t('app', 'Together, these modules equip students with the skills and knowledge needed for further study and careers in environmental sustainability, climate change mitigation, and ecological conservation.') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Modules Section -->
    <div class="modules-section">
        <div class="container">
            <h2 class="section-heading"><?= Yii::t('app', 'Core Modules') ?></h2>
            <p class="section-intro">
                <?= Yii::t('app', 'The Foundation Year curriculum introduces students to core concepts of sustainability, climate change, and environmental management while developing essential academic and professional skills.') ?>
            </p>

            <div class="modules-grid">
                <div class="module-item">
                    <div class="module-number">1</div>
                    <h4><?= Yii::t('app', 'English for Sustainability and Climate Change') ?></h4>
                    <p><?= Yii::t('app', 'Enhances English language proficiency in the context of environmental issues, sustainability topics, and climate science.') ?>
                    </p>
                </div>

                <div class="module-item">
                    <div class="module-number">2</div>
                    <h4><?= Yii::t('app', 'Introduction to Environmental and Sustainable Management') ?></h4>
                    <p><?= Yii::t('app', 'Provides foundational knowledge on managing environmental resources, conservation strategies, and fostering sustainability in organizations.') ?>
                    </p>
                </div>

                <div class="module-item">
                    <div class="module-number">3</div>
                    <h4><?= Yii::t('app', 'Introduction to Environment and Economics') ?></h4>
                    <p><?= Yii::t('app', 'Explores the economic dimensions of environmental challenges, green economics, and sustainable development principles.') ?>
                    </p>
                </div>

                <div class="module-item">
                    <div class="module-number">4</div>
                    <h4><?= Yii::t('app', 'Introduction to Environmental Policy') ?></h4>
                    <p><?= Yii::t('app', 'Provides an overview of policy frameworks, environmental regulations, and governance structures that influence environmental practices.') ?>
                    </p>
                </div>

                <div class="module-item">
                    <div class="module-number">5</div>
                    <h4><?= Yii::t('app', 'Academic and Professional Skills Development') ?></h4>
                    <p><?= Yii::t('app', 'Develops critical thinking, research methodology, academic writing, and presentation skills essential for university success.') ?>
                    </p>
                </div>

                <div class="module-item">
                    <div class="module-number">6</div>
                    <h4><?= Yii::t('app', 'Environmental Science Fundamentals') ?></h4>
                    <p><?= Yii::t('app', 'Introduces core scientific principles related to ecosystems, biodiversity, climate systems, and environmental sustainability.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-banner">
        <div class="container">
            <h2><?= Yii::t('app', 'Ready to Begin Your Environmental Journey?') ?></h2>
            <p><?= Yii::t('app', 'Join our Foundation Year programme and build a strong foundation for your future in environmental sustainability.') ?>
            </p>
            <?= Html::a(Yii::t('app', 'Apply Now'), ['/application/index'], ['class' => 'btn-cta']) ?>
        </div>
    </div>
</div>