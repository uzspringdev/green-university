<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\NewsCategory $model */
/** @var array $languages */

$this->title = 'Update News Category: ' . $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'News Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->slug, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-category-update">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>

</div>