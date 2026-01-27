<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\MenuItem;
use common\models\Language;

/** @var yii\web\View $this */
/** @var common\models\MenuItem $model */
/** @var yii\widgets\ActiveForm $form */

$languages = Language::getActiveLanguages();
?>

<div class="menu-item-form mt-3">

    <?php $form = ActiveForm::begin(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Configure navigation link properties and translations</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('Cancel', Url::to(['menu/view', 'id' => $model->menu_id]), ['class' => 'btn btn-outline-secondary rounded-pill px-4']) ?>
            <?= Html::submitButton('<i class="bi bi-check-lg me-1"></i> Save Item', ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Link Translations</h5>
                </div>
                <div class="card-body p-4">
                    <?php
                    $items = [];
                    foreach ($languages as $language) {
                        $translation = $model->getTranslation($language->code);
                        $title = $translation ? $translation->title : '';

                        $content = '<div class="form-group mb-0">';
                        $content .= '<label class="form-label fw-bold small text-muted text-uppercase mb-2">Display Title (' . strtoupper($language->code) . ')</label>';
                        $content .= Html::textInput("MenuItemTranslation[{$language->id}][title]", $title, [
                            'class' => 'form-control rounded-pill px-3 py-2',
                            'placeholder' => 'e.g. Home, About Us, Contact'
                        ]);
                        $content .= '</div>';

                        $items[] = [
                            'label' => strtoupper($language->code),
                            'content' => $content,
                            'active' => $language->code === 'uz', // default to UZ
                        ];
                    }

                    echo \yii\bootstrap5\Tabs::widget([
                        'items' => $items,
                        'navType' => 'nav-pills',
                        'options' => ['class' => 'mb-4'],
                    ]);
                    ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Link Destination</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <?= $form->field($model, 'url', [
                                'template' => '{label}<div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-pill-start"><i class="bi bi-link-45deg"></i></span>
                                    {input}
                                </div>{error}{hint}'
                            ])->textInput(['maxlength' => true, 'class' => 'form-control border-start-0 rounded-pill-end', 'placeholder' => '/site/index or https://...']) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'page_id', [
                                'template' => '{label}<div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-pill-start"><i class="bi bi-file-earmark-text"></i></span>
                                    {input}
                                </div>{error}{hint}'
                            ])->textInput(['placeholder' => 'Optional: ID of a dynamic page', 'class' => 'form-control border-start-0 rounded-pill-end']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Hierarchy & Status</h5>
                </div>
                <div class="card-body p-4">
                    <?php
                    $parents = [];
                    if ($model->menu_id) {
                        $parents = MenuItem::find()
                            ->where(['menu_id' => $model->menu_id])
                            ->andWhere(['is', 'parent_id', null])
                            ->andWhere(['!=', 'id', $model->id ?? 0])
                            ->all();
                        $parents = \yii\helpers\ArrayHelper::map($parents, 'id', function ($item) {
                            $trans = $item->getTranslation('en');
                            return $trans ? $trans->title : "Item #{$item->id}";
                        });
                    }
                    ?>
                    <?= $form->field($model, 'parent_id')->dropDownList($parents, [
                        'prompt' => 'No Parent (Root Item)',
                        'class' => 'form-select rounded-pill'
                    ]) ?>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <?= $form->field($model, 'sort_order')->input('number', ['class' => 'form-control rounded-pill']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList([
                                MenuItem::STATUS_ACTIVE => 'Active',
                                MenuItem::STATUS_INACTIVE => 'Inactive',
                            ], ['class' => 'form-select rounded-pill']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-light border">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-question-circle fs-2 text-primary opacity-50 mb-3 d-block"></i>
                    <h6 class="fw-bold">How it works</h6>
                    <p class="small text-muted mb-0 text-start">If you provide both a <strong>URL</strong> and a
                        <strong>Page ID</strong>, the URL takes precedence. Use Page ID for internal dynamic pages
                        created in the "Pages" module.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>