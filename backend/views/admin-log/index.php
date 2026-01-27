<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Activity Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-index mt-3 text-start">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Track all administrative actions and system updates</p>
        </div>
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
                        'attribute' => 'created_at',
                        'label' => 'Time',
                        'format' => ['datetime', 'php:d M Y, H:i:s'],
                        'contentOptions' => ['class' => 'ps-4 text-muted small', 'style' => 'width: 200px;'],
                        'headerOptions' => ['class' => 'ps-4'],
                    ],
                    [
                        'attribute' => 'user_id',
                        'label' => 'Admin',
                        'value' => function ($model) {
                                        return $model->user ? $model->user->username : 'System';
                                    },
                        'contentOptions' => ['class' => 'fw-bold text-dark'],
                    ],
                    [
                        'attribute' => 'action',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $badgeClass = 'bg-secondary';
                                        if (stripos($model->action, 'create') !== false)
                                            $badgeClass = 'bg-success';
                                        if (stripos($model->action, 'update') !== false)
                                            $badgeClass = 'bg-info';
                                        if (stripos($model->action, 'delete') !== false)
                                            $badgeClass = 'bg-danger';

                                        return Html::tag('span', strtoupper($model->action), [
                                            'class' => 'badge rounded-pill px-3 ' . $badgeClass . ' bg-opacity-10 text-' . str_replace('bg-', '', $badgeClass)
                                        ]);
                                    }
                    ],
                    [
                        'attribute' => 'model',
                        'label' => 'Entity',
                        'contentOptions' => ['class' => 'font-monospace small'],
                    ],
                    [
                        'attribute' => 'model_id',
                        'label' => 'ID',
                        'contentOptions' => ['class' => 'text-muted small', 'style' => 'width: 80px;'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Actions',
                        'headerOptions' => ['class' => 'text-end pe-4', 'style' => 'width: 80px;'],
                        'contentOptions' => ['class' => 'text-end pe-4'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-eye"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light rounded-circle',
                                                'title' => 'View Details',
                                            ]);
                                        },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>