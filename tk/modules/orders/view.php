<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/OrderModel.php';
require_once '../../models/ClientModel.php';
require_once '../../models/DriverModel.php';
require_once '../../models/VehicleModel.php';

requireAuth();

$orderId = $_GET['id'] ?? null;
if (!$orderId) {
    header("Location: index.php?error=order_id_required");
    exit;
}

try {
    $con = getDBConnection();
    $order = OrderModel::getById($con, $orderId);

    if (!$order) {
        header("Location: index.php?error=order_not_found");
        exit;
    }

    // Проверка прав доступа
    if ($_SESSION['role'] === 'driver' && $order['driver_id'] != $_SESSION['entity_id']) {
        header("Location: index.php?error=access_denied");
        exit;
    }

    if ($_SESSION['role'] === 'client' && $order['client_id'] != $_SESSION['entity_id']) {
        header("Location: index.php?error=access_denied");
        exit;
    }

    // Получаем связанные данные
    $client = ClientModel::getById($con, $order['client_id']);
    $driver = $order['driver_id'] ? DriverModel::getById($con, $order['driver_id']) : null;
    $vehicle = $order['vehicle_id'] ? VehicleModel::getById($con, $order['vehicle_id']) : null;

    $pageTitle = "Заказ #{$orderId}";

} catch (Exception $e) {
    header("Location: index.php?error=" . urlencode($e->getMessage()));
    exit;
}

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Заказ #<?= $orderId ?></h1>
    <div class="header-actions">
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад
        </a>
        <?php if (hasPermission('edit_orders')): ?>
            <a href="edit.php?id=<?= $orderId ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Редактировать
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="order-details">
    <div class="detail-grid">
        <div class="detail-card">
            <h3>Основная информация</h3>
            <div class="detail-item">
                <label>Статус:</label>
                <span class="status-badge status-<?= $order['status'] ?>">
                    <?= getStatusText($order['status']) ?>
                </span>
            </div>
            <div class="detail-item">
                <label>Дата создания:</label>
                <span><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></span>
            </div>
            <?php if ($order['delivery_date']): ?>
                <div class="detail-item">
                    <label>Дата доставки:</label>
                    <span><?= date('d.m.Y H:i', strtotime($order['delivery_date'])) ?></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="detail-card">
            <h3>Маршрут</h3>
            <div class="detail-item">
                <label>Откуда:</label>
                <span><?= htmlspecialchars($order['origin']) ?></span>
            </div>
            <div class="detail-item">
                <label>Куда:</label>
                <span><?= htmlspecialchars($order['destination']) ?></span>
            </div>
            <div class="detail-item">
                <label>Расстояние:</label>
                <span><?= $order['distance_km'] ? $order['distance_km'] . ' км' : 'Не указано' ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h3>Груз</h3>
            <div class="detail-item">
                <label>Описание:</label>
                <span><?= htmlspecialchars($order['cargo_description']) ?: 'Не указано' ?></span>
            </div>
            <div class="detail-item">
                <label>Вес:</label>
                <span><?= $order['weight_kg'] ? $order['weight_kg'] . ' кг' : 'Не указано' ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h3>Участники</h3>
            <div class="detail-item">
                <label>Клиент:</label>
                <span><?= htmlspecialchars($client['full_name']) ?></span>
            </div>
            <?php if ($driver): ?>
                <div class="detail-item">
                    <label>Водитель:</label>
                    <span><?= htmlspecialchars($driver['full_name']) ?></span>
                </div>
            <?php endif; ?>
            <?php if ($vehicle): ?>
                <div class="detail-item">
                    <label>Транспорт:</label>
                    <span><?= htmlspecialchars($vehicle['plate_number']) ?> (<?= $vehicle['model'] ?>)</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (hasPermission('update_order_status') && in_array($order['status'], ['new', 'picked_up'])): ?>
        <div class="action-panel">
            <h3>Действия с заказом</h3>
            <div class="action-buttons">
                <?php if ($order['status'] === 'new'): ?>
                    <form action="../../controllers/update_order_status.php" method="POST" class="inline-form">
                        <input type="hidden" name="order_id" value="<?= $orderId ?>">
                        <input type="hidden" name="status" value="picked_up">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-truck-loading"></i> Забран со склада
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($order['status'] === 'picked_up'): ?>
                    <form action="../../controllers/update_order_status.php" method="POST" class="inline-form">
                        <input type="hidden" name="order_id" value="<?= $orderId ?>">
                        <input type="hidden" name="status" value="delivered">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Доставлен
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .detail-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .detail-card h3 {
        margin-bottom: 15px;
        color: var(--dark);
        border-bottom: 2px solid var(--light);
        padding-bottom: 10px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .detail-item label {
        font-weight: 600;
        color: var(--dark);
    }

    .detail-item span {
        text-align: right;
    }

    .action-panel {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .action-panel h3 {
        margin-bottom: 15px;
        color: var(--dark);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .inline-form {
        display: inline;
    }
</style>

<?php require '../../templates/footer.php'; ?>