<?php

use common\models\NewsCategory;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'News Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Organize your news into thematic sections</p>
        </div>
        <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Create Category', ['create'], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'headerRowOptions' => ['class' => 'bg-light text-muted small text-uppercase fw-bold'],
                'summaryOptions' => ['class' => 'p-3 text-muted small border-bottom'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['class' => 'ps-4 text-muted small', 'style' => 'width: 50px;'],
                        'headerOptions' => ['class' => 'ps-4'],
                    ],
                    [
                        'attribute' => 'id',
                        'contentOptions' => ['class' => 'text-muted font-monospace small', 'style' => 'width: 80px;'],
                    ],
                    [
                        'label' => 'Name (UZ)',
                        'value' => function ($model) {
                                        $trans = $model->getTranslation('uz');
                                        return $trans ? $trans->name : '<span class="text-danger italic">No transl.</span>';
                                    },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'slug',
                        'contentOptions' => ['class' => 'text-muted small'],
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $isActive = $model->status === NewsCategory::STATUS_ACTIVE;
                                        return Html::tag('span', $isActive ? 'Active' : 'Inactive', [
                                            'class' => 'badge rounded-pill ' . ($isActive ? 'bg-success bg-opacity-10 text-success px-3' : 'bg-warning bg-opacity-10 text-dark px-3')
                                        ]);
                                    },
                        'contentOptions' => ['style' => 'width: 120px;'],
                    ],
                    [
                        'class' => ActionColumn::class,
                        'header' => 'Actions',
                        'headerOptions' => ['class' => 'text-end pe-4', 'style' => 'width: 120px;'],
                        'contentOptions' => ['class' => 'text-end pe-4'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-eye"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light rounded-circle ms-1',
                                                'title' => 'View',
                                            ]);
                                        },
                            'update' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-pencil"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light text-primary rounded-circle ms-1',
                                                'title' => 'Edit',
                                            ]);
                                        },
                            'delete' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-trash"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light text-danger rounded-circle ms-1',
                                                'title' => 'Delete',
                                                'data-confirm' => 'Are you sure you want to delete this category?',
                                                'data-method' => 'post',
                                            ]);
                                        },
                        ],
                    ],
                ],
                'pager' => [
                    'class' => \yii\bootstrap5\LinkPager::class,
                    'options' => ['class' => 'pagination justify-content-center p-3 mb-0'],
                ],
            ]); ?>
        </div>
    </div>
</div>