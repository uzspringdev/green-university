<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Sliders';
$this->params['breadcrumbs'][] = $this->title;

// Register SortableJS
$this->registerJsFile('https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->registerCss("
    .drag-handle { cursor: grab; color: #ccc; transition: color 0.2s; }
    .drag-handle:hover { color: #0d6efd; }
    .sortable-ghost { opacity: 0.4; background-color: #f8f9fa !important; border: 2px dashed #0d6efd !important; }
    .sortable-drag { background: #fff !important; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
");

$this->registerJs("
    const el = document.querySelector('.slider-grid table tbody');
    if (el) {
        new Sortable(el, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function() {
                const items = [];
                el.querySelectorAll('tr').forEach(tr => {
                    items.push(tr.getAttribute('data-key'));
                });

                $.ajax({
                    url: '" . Url::to(['slider/sort']) . "',
                    type: 'POST',
                    data: {
                        items: items,
                        _csrf: yii.getCsrfToken()
                    },
                    success: function(response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.success) {
                                console.log('Slider order saved');
                            }
                        } catch(e) {}
                    }
                });
            }
        });
    }
");
?>
<div class="slider-index mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Drag <i class="bi bi-grip-vertical"></i> to reorder slides and manage homepage
                content</p>
        </div>
        <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Create Slider', ['create'], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0 slider-grid">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'headerRowOptions' => ['class' => 'bg-light text-muted small text-uppercase fw-bold'],
                'summaryOptions' => ['class' => 'p-3 text-muted small border-bottom'],
                'columns' => [
                    [
                        'label' => '',
                        'format' => 'raw',
                        'value' => function () {
                                        return '<i class="bi bi-grip-vertical fs-5 drag-handle"></i>';
                                    },
                        'contentOptions' => ['style' => 'width: 40px;', 'class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'image',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        if (!$model->image)
                                            return '<div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:120px; height:60px;"><i class="bi bi-image text-muted opacity-50"></i></div>';
                                        return Html::img($model->getImageUrl(), [
                                            'class' => 'rounded shadow-sm border',
                                            'style' => 'width:120px; height:60px; object-fit: cover;'
                                        ]);
                                    },
                        'contentOptions' => ['style' => 'width: 150px;'],
                    ],
                    [
                        'attribute' => 'link_url',
                        'value' => function ($model) {
                                        return $model->link_url ? Html::a($model->link_url, $model->link_url, ['target' => '_blank', 'class' => 'text-primary text-decoration-none small']) : '<span class="text-muted small italic">No link</span>';
                                    },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'sort_order',
                        'contentOptions' => ['class' => 'text-center fw-bold text-muted small'],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $isActive = $model->status == \common\models\Slider::STATUS_ACTIVE;
                                        return Html::tag('span', $isActive ? 'Active' : 'Inactive', [
                                            'class' => 'badge rounded-pill ' . ($isActive ? 'bg-success bg-opacity-10 text-success px-3' : 'bg-warning bg-opacity-10 text-dark px-3')
                                        ]);
                                    },
                        'contentOptions' => ['style' => 'width: 120px;'],
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
                                                'data-confirm' => 'Are you sure you want to delete this slider?',
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