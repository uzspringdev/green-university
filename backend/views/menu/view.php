<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Menu $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Register SortableJS
$this->registerJsFile('https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->registerCss("
    .menu-list { min-height: 10px; }
    .menu-item-node { margin-bottom: 0.5rem; }
    .drag-handle { cursor: grab; color: #ccc; transition: color 0.2s; }
    .drag-handle:hover { color: #0d6efd; }
    .sortable-ghost { opacity: 0.4; background-color: #f8f9fa !important; border: 2px dashed #0d6efd !important; }
    .sortable-drag { background: #fff !important; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .menu-item-children { min-height: 5px; margin-left: 2rem; border-left: 1px dashed #dee2e6; }
    .card .btn-group-sm .btn { padding: 0.2rem 0.4rem; }
    .empty-placeholder { color: #adb5bd; border: 1px dashed #dee2e6; border-radius: 0.5rem; padding: 0.5rem; font-size: 0.8rem; text-align: center; margin-bottom: 0.5rem; }
");

$this->registerJs("
    function initSortable() {
        const lists = document.querySelectorAll('.nested-sortable');
        lists.forEach(el => {
            if (el.sortable) el.sortable.destroy();
            el.sortable = new Sortable(el, {
                group: 'nested',
                handle: '.drag-handle',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onEnd: function() {
                    saveOrder();
                }
            });
        });
    }

    function saveOrder() {
        const items = [];
        const processList = (parentEl, parentId = null) => {
            const listItems = Array.from(parentEl.children).filter(child => child.classList.contains('menu-item-node'));
            listItems.forEach((li, index) => {
                const id = li.getAttribute('data-id');
                items.push({
                    id: id,
                    parent_id: parentId,
                    sort_order: index + 1
                });
                
                const childrenContainer = li.querySelector('.menu-item-children');
                if (childrenContainer) {
                    const subList = childrenContainer.querySelector('.nested-sortable');
                    if (subList) {
                        processList(subList, id);
                    }
                }
            });
        };
        
        const rootContainer = document.querySelector('.menu-tree-root');
        if (rootContainer) {
            const rootList = rootContainer.querySelector('.nested-sortable');
            if (rootList) {
                processList(rootList);
                
                $.ajax({
                    url: '" . Url::to(['menu-item/sort']) . "',
                    type: 'POST',
                    data: {
                        items: items,
                        _csrf: yii.getCsrfToken()
                    },
                    success: function(response) {
                        console.log('Hierarchy saved');
                    }
                });
            }
        }
    }

    initSortable();
");

// Define recursive renderer as a closure
$renderMenuTree = function ($items) use (&$renderMenuTree) {
    if (empty($items)) {
        return '<ul class="menu-list list-unstyled nested-sortable mt-1"></ul>';
    }

    $html = '<ul class="menu-list list-unstyled nested-sortable">';
    foreach ($items as $item) {
        $translation = $item->getTranslation();
        $title = $translation ? $translation->title : null;
        if (!$title) {
            $title = '(no translation)';
        }
        $isActive = $item->status == \common\models\MenuItem::STATUS_ACTIVE;

        $html .= '<li class="menu-item-node" data-id="' . $item->id . '">';
        $html .= '<div class="card border-0 shadow-sm border-start border-4 ' . ($isActive ? 'border-primary' : 'border-warning') . ' mb-1">';
        $html .= '<div class="card-body p-2 d-flex align-items-center justify-content-between">';
        $html .= '<div class="d-flex align-items-center gap-3">';
        $html .= '<i class="bi bi-grip-vertical fs-5 drag-handle text-muted"></i>';
        $html .= '<div>';
        $html .= '<div class="fw-bold text-dark small" style="font-size: 0.85rem;">' . Html::encode($title) . '</div>';
        $html .= '<div class="text-muted font-monospace" style="font-size: 0.7rem;">' . Html::encode($item->url) . '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="d-flex align-items-center gap-1">';
        $html .= Html::a('<i class="bi bi-pencil"></i>', ['menu-item/update', 'id' => $item->id], ['class' => 'btn btn-sm btn-light text-primary rounded-circle', 'title' => 'Edit']);
        $html .= Html::a('<i class="bi bi-trash"></i>', ['menu-item/delete', 'id' => $item->id], [
            'class' => 'btn btn-sm btn-light text-danger rounded-circle',
            'title' => 'Delete',
            'data-confirm' => 'Are you sure you want to delete this menu item and all its children?',
            'data-method' => 'post'
        ]);
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        $children = $item->getAdminChildren()->all();
        $html .= '<div class="menu-item-children">';
        $html .= $renderMenuTree($children);
        $html .= '</div>';
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
};

?>
<div class="menu-view mt-3 text-start">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Manage hierarchical navigation structure and item ordering</p>
        </div>
        <div class="d-flex gap-2 text-start">
            <?= Html::a('<i class="bi bi-pencil me-1"></i> Update Menu', ['update', 'id' => $model->id], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
            <?= Html::a('<i class="bi bi-trash me-1"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger rounded-pill px-4 shadow-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this menu?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row g-4 text-start">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-muted small text-uppercase mb-0">Menu Hierarchy</h5>
                <?= Html::a('<i class="bi bi-plus-lg me-1"></i> Add Root Item', ['menu-item/create', 'menu_id' => $model->id], ['class' => 'btn btn-sm btn-success rounded-pill px-3 shadow-sm']) ?>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 menu-tree-root">
                    <?php
                    $rootItems = $model->getRootItems()->all();
                    if (empty($rootItems)) {
                        echo '<div class="text-center py-5 text-muted">';
                        echo '<i class="bi bi-list-nested display-1 opacity-25 mb-3 d-block"></i>';
                        echo '<p>No menu items found. Start by adding a root item.</p>';
                        echo '</div>';
                        echo '<ul class="nested-sortable list-unstyled" style="min-height: 50px;"></ul>';
                    } else {
                        echo $renderMenuTree($rootItems);
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 text-start">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div
                    class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Configuration</h5>
                    <?php $isActive = $model->status == 1; ?>
                    <span
                        class="badge rounded-pill px-3 py-2 <?= $isActive ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-dark' ?>">
                        <?= $isActive ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-key me-2 text-primary"></i> Access Code</span>
                            <span class="fw-bold font-monospace bg-light p-1 px-2 rounded"><?= $model->code ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-geo-alt me-2 text-primary"></i> Location</span>
                            <span class="fw-medium"><?= Html::encode($model->location ?: 'Not specified') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm border-start border-4 border-info">
                <div class="card-body p-4 text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-info-circle fs-3 text-info"></i>
                        <h6 class="mb-0 fw-bold">Nesting Instructions</h6>
                    </div>
                    <ul class="small text-muted ps-3 mb-0">
                        <li class="mb-2">Drag the <i class="bi bi-grip-vertical"></i> handle to reorder items.</li>
                        <li class="mb-2">Drag items <strong>to the right</strong> into the dashed area of another item
                            to make it a child.</li>
                        <li>Drag child items <strong>to the left</strong> to move them back to a higher level.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>