<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Manage student admission applications</p>
        </div>
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
                        'attribute' => 'first_name',
                        'value' => function ($model) {
                                        return Html::tag('div', Html::encode($model->getFullName()), ['class' => 'fw-bold text-dark']) .
                                            Html::tag('div', Html::encode($model->email), ['class' => 'text-muted small']);
                                    },
                        'format' => 'raw',
                        'label' => 'Applicant',
                    ],
                    'phone',
                    'program',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $status = $model->status;
                                        $class = 'bg-secondary';
                                        if ($status == \common\models\Application::STATUS_NEW)
                                            $class = 'bg-warning text-dark';
                                        if ($status == \common\models\Application::STATUS_PROCESSING)
                                            $class = 'bg-info text-white';
                                        if ($status == \common\models\Application::STATUS_APPROVED)
                                            $class = 'bg-success text-white';

                                        return Html::tag('span', $model->getStatusLabel(), [
                                            'class' => 'badge rounded-pill px-3 py-2 ' . $class
                                        ]);
                                    },
                        'contentOptions' => ['style' => 'width: 140px;'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['datetime', 'php:d M Y'],
                        'contentOptions' => ['class' => 'text-muted small'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Actions',
                        'headerOptions' => ['class' => 'text-end pe-4', 'style' => 'width: 150px;'],
                        'contentOptions' => ['class' => 'text-end pe-4'],
                        'template' => '{view} {update-status} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-eye"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light rounded-circle ms-1',
                                                'title' => 'View Details',
                                                'data-bs-toggle' => 'tooltip'
                                            ]);
                                        },
                            'update-status' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-pencil-square"></i>', ['update-status', 'id' => $model->id], [
                                                'class' => 'btn btn-sm btn-icon btn-light text-primary rounded-circle ms-1',
                                                'title' => 'Update Status',
                                                'data-bs-toggle' => 'tooltip'
                                            ]);
                                        },
                            'delete' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-trash"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light text-danger rounded-circle ms-1',
                                                'title' => 'Delete',
                                                'data-bs-toggle' => 'tooltip',
                                                'data-confirm' => 'Are you sure you want to delete this application?',
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