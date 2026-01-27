<?php
use yii\helpers\Html;

$this->title = 'Update Slider: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="slider-update">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    <?= $this->render('_form', ['model' => $model, 'languages' => $languages]) ?>
</div>