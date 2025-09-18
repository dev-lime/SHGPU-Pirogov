<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/ClientModel.php';

requireAuth();
requirePermission('view_all');

$pageTitle = 'Управление клиентами';
$clients = ClientModel::getAll();

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Управление клиентами</h1>
    <div class="header-actions">
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Новый клиент
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Компания</th>
                <th>Дата регистрации</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td>#<?= $client['client_id'] ?></td>
                    <td><?= htmlspecialchars($client['full_name']) ?></td>
                    <td><?= htmlspecialchars($client['phone'] ?? 'Не указан') ?></td>
                    <td><?= htmlspecialchars($client['email'] ?? 'Не указан') ?></td>
                    <td><?= htmlspecialchars($client['company_name'] ?? 'Частное лицо') ?></td>
                    <td>
                        <?php if (!empty($client['created_at'])): ?>
                            <?= date('d.m.Y', strtotime($client['created_at'])) ?>
                        <?php else: ?>
                            Не указана
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="edit.php?id=<?= $client['client_id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="delete.php" method="POST" class="inline-form"
                                onsubmit="return confirm('Удалить клиента?')">
                                <input type="hidden" name="client_id" value="<?= $client['client_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../../templates/footer.php'; ?>