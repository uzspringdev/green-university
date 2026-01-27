<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Staff Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1 text-dark">
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted smallest mb-0">Manage administrative authority and module permissions</p>
        </div>
        <?= Html::a('<i class="bi bi-person-plus-fill me-2"></i> Onboard New staff', ['create'], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'headerRowOptions' => ['class' => 'bg-light text-muted smallest fw-bold uppercase px-4'],
                'summary' => false,
                'columns' => [
                    [
                        'attribute' => 'username',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        return '<div class="d-flex align-items-center gap-3 py-2 px-3">
                                <div class="avatar-sm bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">' .
                                            strtoupper(substr($model->username, 0, 1)) .
                                            '</div>
                                <div>
                                    <div class="fw-bold text-dark">' . Html::encode($model->username) . '</div>
                                    <div class="smallest text-muted">' . Html::encode($model->email) . '</div>
                                </div>
                            </div>';
                                    }
                    ],
                    [
                        'attribute' => 'role',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $class = $model->role == User::ROLE_SUPER_ADMIN ? 'bg-danger text-white' : 'bg-primary text-white';
                                        return '<span class="badge rounded-pill ' . $class . ' px-3 py-1">' . $model->getRoleLabel() . '</span>';
                                    }
                    ],
                    [
                        'label' => 'Authorized Modules',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        if ($model->isSuperAdmin()) {
                                            return '<span class="text-success smallest fw-bold"><i class="bi bi-infinity me-1"></i> Universal Access</span>';
                                        }
                                        $perms = $model->getPermissionsList();
                                        if (empty($perms))
                                            return '<span class="text-muted smallest italics">None</span>';

                                        $output = '<div class="d-flex flex-wrap gap-1">';
                                        foreach ($perms as $perm) {
                                            $output .= '<span class="badge bg-light text-dark border extra-small">' . ucfirst($perm) . '</span>';
                                        }
                                        $output .= '</div>';
                                        return $output;
                                    }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                                        $class = $model->status == User::STATUS_ACTIVE ? 'success' : 'warning';
                                        $label = $model->status == User::STATUS_ACTIVE ? 'Active' : 'Inactive';
                                        return '<span class="status-badge-modern ' . $class . '"><span class="pulse-dot"></span>' . $label . '</span>';
                                    }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view} {update} {delete}',
                        'contentOptions' => ['class' => 'text-end px-4'],
                        'buttons' => [
                            'view' => function ($url) {
                                            return Html::a('<i class="bi bi-eye"></i>', $url, ['class' => 'btn btn-icon btn-light text-primary rounded-pill me-1']);
                                        },
                            'update' => function ($url) {
                                            return Html::a('<i class="bi bi-pencil"></i>', $url, ['class' => 'btn btn-icon btn-light text-success rounded-pill me-1']);
                                        },
                            'delete' => function ($url, $model) {
                                            if ($model->id == Yii::$app->user->id)
                                                return '';
                                            return Html::a('<i class="bi bi-trash"></i>', $url, [
                                                'class' => 'btn btn-icon btn-light text-danger rounded-pill',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to revoke this user\'s access?',
                                                    'method' => 'post',
                                                ],
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
    .avatar-sm {
        font-size: 0.875rem;
    }

    .bg-primary-light {
        background-color: rgba(27, 67, 50, 0.1);
    }

    .uppercase {
        letter-spacing: 0.05em;
    }

    .italics {
        font-style: italic;
    }
</style>