<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/OrderModel.php';
require_once '../../models/ClientModel.php';

requireAuth();
requirePermission('view_orders');

$pageTitle = 'Управление заказами';
$filter = $_GET['filter'] ?? 'all';

// Фильтрация заказов по ролям
if ($_SESSION['role'] === 'driver') {
    $orders = OrderModel::getDriverOrders($_SESSION['entity_id']);
} elseif ($_SESSION['role'] === 'client') {
    $orders = OrderModel::getClientOrders($_SESSION['entity_id']);
} else {
    $orders = OrderModel::getAllWithDetails();
}

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Управление заказами</h1>
    <div class="header-actions">
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Новый заказ
        </a>
    </div>
</div>

<div class="filters">
    <a href="?filter=all" class="filter-btn <?= $filter === 'all' ? 'active' : '' ?>">Все</a>
    <a href="?filter=active" class="filter-btn <?= $filter === 'active' ? 'active' : '' ?>">Активные</a>
    <a href="?filter=completed" class="filter-btn <?= $filter === 'completed' ? 'active' : '' ?>">Завершённые</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Клиент</th>
                <th>Маршрут</th>
                <th>Водитель</th>
                <th>Статус</th>
                <th>Создан</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['order_id'] ?></td>
                    <td><?= htmlspecialchars($order['client_name']) ?></td>
                    <td><?= htmlspecialchars($order['origin']) ?> → <?= htmlspecialchars($order['destination']) ?></td>
                    <td><?= htmlspecialchars($order['driver_name'] ?? 'Не назначен') ?></td>
                    <td>
                        <span class="status-badge status-<?= $order['status'] ?>">
                            <?= getStatusText($order['status']) ?>
                        </span>
                    </td>
                    <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="view.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if (hasPermission('edit_orders')): ?>
                                <a href="edit.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../../templates/footer.php'; ?>