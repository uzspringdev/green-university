<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Footer Blocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="footer-block-index mt-3 text-start">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Manage content blocks displayed in the website footer</p>
        </div>
        <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Add Footer Block', ['create'], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
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
                        'attribute' => 'column_position',
                        'format' => 'raw',
                        'label' => 'Column',
                        'value' => function ($model) {
                                        $columns = [
                                            1 => 'Column 1',
                                            2 => 'Column 2',
                                            3 => 'Column 3',
                                            4 => 'Column 4',
                                        ];
                                        $label = $columns[$model->column_position] ?? 'Unknown';
                                        return Html::tag('span', $label, ['class' => 'badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill']);
                                    },
                        'contentOptions' => ['style' => 'width: 120px;'],
                    ],
                    [
                        'attribute' => 'sort_order',
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width: 100px;'],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'title',
                        'label' => 'Display Title',
                        'value' => function ($model) {
                                        $translation = $model->getTranslation();
                                        return $translation ? $translation->title : '(no translation)';
                                    }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $isActive = $model->status == \common\models\FooterBlock::STATUS_ACTIVE;
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
                                                'data-confirm' => 'Are you sure you want to delete this footer block?',
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