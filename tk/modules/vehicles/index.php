<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/VehicleModel.php';
require_once '../../models/DriverModel.php';

requireAuth();
requirePermission('view_all');

$pageTitle = 'Транспортные средства';
$vehicles = VehicleModel::getAllWithDrivers();

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Транспортные средства</h1>
    <div class="header-actions">
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить транспорт
        </a>
    </div>
</div>

<div class="ios-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Гос. номер</th>
                    <th>Модель</th>
                    <th>Грузоподъемность</th>
                    <th>Водитель</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td>#<?= $vehicle['vehicle_id'] ?></td>
                        <td>
                            <strong><?= htmlspecialchars($vehicle['plate_number']) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($vehicle['model']) ?></td>
                        <td><?= $vehicle['capacity_kg'] ?> кг</td>
                        <td>
                            <?php if ($vehicle['driver_name']): ?>
                                <?= htmlspecialchars($vehicle['driver_name']) ?>
                            <?php else: ?>
                                <span class="text-muted">Не назначен</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge status-<?= $vehicle['status'] ?>">
                                <?= getVehicleStatusText($vehicle['status']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit.php?id=<?= $vehicle['vehicle_id'] ?>" class="btn btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="maintenance.php?id=<?= $vehicle['vehicle_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-tools"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="ios-card">
    <h3>Статистика транспорта</h3>
    <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--ios-green);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?= count(array_filter($vehicles, fn($v) => $v['status'] === 'available')) ?></h3>
                <p>Доступно</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--ios-primary);">
                <i class="fas fa-truck-moving"></i>
            </div>
            <div class="stat-content">
                <h3><?= count(array_filter($vehicles, fn($v) => $v['status'] === 'in_transit')) ?></h3>
                <p>В рейсе</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--ios-orange);">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-content">
                <h3><?= count(array_filter($vehicles, fn($v) => $v['status'] === 'maintenance')) ?></h3>
                <p>На обслуживании</p>
            </div>
        </div>
    </div>
</div>

<?php
function getVehicleStatusText($status)
{
    $statuses = [
        'available' => 'Доступен',
        'in_transit' => 'В рейсе',
        'maintenance' => 'Обслуживание'
    ];
    return $statuses[$status] ?? $status;
}
require '../../templates/footer.php';
?>