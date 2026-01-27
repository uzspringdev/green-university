<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'University Symbols';
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
    const el = document.querySelector('.symbol-grid table tbody');
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
                    url: '" . Url::to(['symbol/sort']) . "',
                    type: 'POST',
                    data: {
                        items: items,
                        _csrf: yii.getCsrfToken()
                    },
                    success: function(response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.success) {
                                console.log('Order saved');
                            }
                        } catch(e) {}
                    }
                });
            }
        });
    }
");
?>
<div class="symbol-index mt-3 text-start">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Drag <i class="bi bi-grip-vertical"></i> to reorder university symbols and key
                indicators</p>
        </div>
        <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Add Symbol', ['create'], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0 symbol-grid text-start">
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
                        'attribute' => 'icon',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        return Html::tag('div', '<i class="' . Html::encode($model->icon ?: 'bi bi-app') . ' fs-4"></i>', [
                                            'class' => 'bg-light rounded p-2 d-inline-block text-primary shadow-sm'
                                        ]);
                                    },
                        'contentOptions' => ['style' => 'width: 80px;', 'class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'title',
                        'label' => 'Title',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $translation = $model->getTranslation();
                                        $title = $translation ? $translation->title : '(no translation)';
                                        return Html::tag('div', Html::encode($title), ['class' => 'fw-bold text-dark']) .
                                            Html::tag('div', 'Value: ' . Html::encode($model->value), ['class' => 'small text-muted mt-1']);
                                    }
                    ],
                    [
                        'attribute' => 'sort_order',
                        'contentOptions' => ['class' => 'text-center text-muted small'],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $isActive = $model->status == \common\models\Symbol::STATUS_ACTIVE;
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
                                                'data-confirm' => 'Are you sure you want to delete this symbol?',
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