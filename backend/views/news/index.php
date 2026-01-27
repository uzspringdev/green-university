<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'News Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Manage and publish news articles for the website</p>
        </div>
        <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Create News', ['create'], ['class' => 'btn btn-success rounded-pill px-4 shadow-sm']) ?>
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
                        'attribute' => 'image',
                        'label' => 'Image',
                        'format' => 'html',
                        'value' => function ($model) {
                                        return $model->image ? Html::img($model->getImageUrl(), [
                                            'class' => 'rounded shadow-sm border',
                                            'style' => 'width:80px; height:50px; object-fit:cover;'
                                        ]) : '<div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width:80px; height:50px;"><i class="bi bi-image fs-4"></i></div>';
                                    },
                        'contentOptions' => ['style' => 'width: 100px;'],
                    ],
                    [
                        'label' => 'Title',
                        'attribute' => 'id', // Using id as attribute to allow sorting by id if needed, but showing title
                        'format' => 'raw',
                        'value' => function ($model) {
                                        // Specific priority: uz > en > ru
                                        $trans = $model->getTranslation('uz')
                                            ?: $model->getTranslation('en')
                                            ?: $model->getTranslation('ru')
                                            ?: ($model->translations ? $model->translations[0] : null);

                                        $title = $trans ? $trans->title : '<span class="text-danger italic small">No title</span>';
                                        $slug = Html::tag('div', $model->slug, ['class' => 'text-muted extra-small font-monospace']);
                                        return Html::tag('div', $title, ['class' => 'fw-bold text-dark']) . $slug;
                                    },
                        'contentOptions' => ['class' => 'py-3'],
                    ],
                    [
                        'attribute' => 'category_id',
                        'value' => function ($model) {
                                        if ($model->category) {
                                            $trans = $model->category->getTranslation('uz')
                                                ?: $model->category->getTranslation('en')
                                                ?: $model->category->getTranslation('ru');
                                            return $trans ? $trans->name : 'N/A';
                                        }
                                        return 'N/A';
                                    },
                        'contentOptions' => ['class' => 'text-muted small'],
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $isPublished = $model->status == \common\models\News::STATUS_PUBLISHED;
                                        return Html::tag('span', $isPublished ? 'Published' : 'Draft', [
                                            'class' => 'badge rounded-pill px-3 py-2 ' . ($isPublished ? 'bg-success text-white' : 'bg-warning text-dark')
                                        ]);
                                    },
                        'contentOptions' => ['style' => 'width: 120px;'],
                    ],
                    [
                        'attribute' => 'is_featured',
                        'label' => 'Featured',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        return $model->is_featured ? '<i class="bi bi-star-fill text-warning fs-5"></i>' : '<i class="bi bi-star text-muted fs-5"></i>';
                                    },
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width: 80px;'],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'published_at',
                        'label' => 'Date',
                        'format' => ['datetime', 'php:d M Y'],
                        'contentOptions' => ['class' => 'text-muted small', 'style' => 'width: 120px;'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Actions',
                        'headerOptions' => ['class' => 'text-end pe-4', 'style' => 'width: 120px;'],
                        'contentOptions' => ['class' => 'text-end pe-4'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-eye"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light rounded-circle ms-1',
                                                'title' => 'View',
                                                'data-bs-toggle' => 'tooltip'
                                            ]);
                                        },
                            'update' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-pencil"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light text-primary rounded-circle ms-1',
                                                'title' => 'Update',
                                                'data-bs-toggle' => 'tooltip'
                                            ]);
                                        },
                            'delete' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-trash"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light text-danger rounded-circle ms-1',
                                                'title' => 'Delete',
                                                'data-bs-toggle' => 'tooltip',
                                                'data-confirm' => 'Are you sure you want to delete this item?',
                                                'data-method' => 'post',
                                            ]);
                                        },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<style>
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>