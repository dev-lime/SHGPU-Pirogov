<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/DriverModel.php';
require_once '../../models/VehicleModel.php';

requireAuth();
requirePermission('view_all');

$pageTitle = 'Водители';
$drivers = DriverModel::getAllWithVehicles();

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Водители</h1>
    <div class="header-actions">
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить водителя
        </a>
    </div>
</div>

<div class="ios-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Телефон</th>
                    <th>Номер прав</th>
                    <th>Транспорт</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($drivers as $driver): ?>
                    <tr>
                        <td>#<?= $driver['driver_id'] ?></td>
                        <td>
                            <div class="driver-info">
                                <strong><?= htmlspecialchars($driver['full_name']) ?></strong>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($driver['email']) ?></small>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($driver['phone']) ?></td>
                        <td><?= htmlspecialchars($driver['license_number']) ?></td>
                        <td>
                            <?php if ($driver['vehicle_id']): ?>
                                <span class="vehicle-badge">
                                    <?= htmlspecialchars($driver['plate_number']) ?>
                                    <br>
                                    <small><?= htmlspecialchars($driver['model']) ?></small>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Не назначен</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge status-<?= $driver['status'] ?>">
                                <?= $driver['status'] === 'active' ? 'Активен' : 'Неактивен' ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="view.php?id=<?= $driver['driver_id'] ?>" class="btn btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="edit.php?id=<?= $driver['driver_id'] ?>" class="btn btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require '../../templates/footer.php'; ?>