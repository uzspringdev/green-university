<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\NewsCategory $model */
/** @var array $languages */

$this->title = 'Create News Category';
$this->params['breadcrumbs'][] = ['label' => 'News Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-create">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>

</div>