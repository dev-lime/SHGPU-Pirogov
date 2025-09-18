<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/DispatcherModel.php';

requireAuth();
requirePermission('view_all');

$pageTitle = 'Диспетчеры';
$dispatchers = DispatcherModel::getAll();

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Диспетчеры</h1>
    <div class="header-actions">
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить диспетчера
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
                    <th>Email</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dispatchers as $dispatcher): ?>
                    <tr>
                        <td>#<?= $dispatcher['dispatcher_id'] ?></td>
                        <td><?= htmlspecialchars($dispatcher['full_name']) ?></td>
                        <td><?= htmlspecialchars($dispatcher['phone']) ?></td>
                        <td><?= htmlspecialchars($dispatcher['email']) ?></td>
                        <td>
                            <label class="ios-switch">
                                <input type="checkbox" <?= $dispatcher['is_active'] ? 'checked' : '' ?>>
                                <span class="ios-slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit.php?id=<?= $dispatcher['dispatcher_id'] ?>" class="btn btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete.php?id=<?= $dispatcher['dispatcher_id'] ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
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