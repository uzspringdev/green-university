<?php

use common\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Manage website navigation structures</p>
        </div>
        <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Create Menu', ['create'], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
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
                        'attribute' => 'name',
                        'contentOptions' => ['class' => 'fw-bold text-dark'],
                    ],
                    [
                        'attribute' => 'code',
                        'value' => function ($model) {
                                        return Html::tag('span', $model->code, ['class' => 'font-monospace bg-light px-2 py-1 rounded small']);
                                    },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $isActive = $model->status == Menu::STATUS_ACTIVE;
                                        return Html::tag('span', $isActive ? 'Active' : 'Inactive', [
                                            'class' => 'badge rounded-pill ' . ($isActive ? 'bg-success bg-opacity-10 text-success px-3' : 'bg-warning bg-opacity-10 text-dark px-3')
                                        ]);
                                    },
                    ],
                    [
                        'class' => ActionColumn::class,
                        'header' => 'Actions',
                        'headerOptions' => ['class' => 'text-end pe-4', 'style' => 'width: 150px;'],
                        'contentOptions' => ['class' => 'text-end pe-4'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-eye"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light rounded-circle ms-1',
                                                'title' => 'View Details',
                                            ]);
                                        },
                            'update' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-pencil"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light text-primary rounded-circle ms-1',
                                                'title' => 'Edit Menu',
                                            ]);
                                        },
                            'delete' => function ($url, $model) {
                                            return Html::a('<i class="bi bi-trash"></i>', $url, [
                                                'class' => 'btn btn-sm btn-icon btn-light text-danger rounded-circle ms-1',
                                                'title' => 'Delete Menu',
                                                'data-confirm' => 'Are you sure you want to delete this menu?',
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