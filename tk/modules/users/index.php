<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/UserModel.php';
require_once '../../models/RoleModel.php';

requireAuth();
requireRole('admin');

// Получаем всех пользователей с информацией о ролях
$con = getDBConnection();
$sql = "SELECT u.*, r.role_name, r.permissions 
        FROM users u 
        LEFT JOIN roles r ON u.role_id = r.role_id 
        ORDER BY u.user_id";
$result = pg_query($con, $sql);
$users = [];
while ($row = pg_fetch_assoc($result)) {
    if (isset($row['permissions'])) {
        $row['permissions'] = trim($row['permissions'], '{}');
        $row['permissions'] = explode(',', $row['permissions']);
    }
    $users[] = $row;
}

$pageTitle = 'Управление пользователями';

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Управление пользователями</h1>
    <div class="header-actions">
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Новый пользователь
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Логин</th>
                <th>Роль</th>
                <th>Привязка</th>
                <th>Права</th>
                <th>Создан</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>#<?= $user['user_id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['role_name']) ?></td>
                    <td>
                        <?php if ($user['entity_type'] && $user['entity_id']): ?>
                            <?= $user['entity_type'] ?> #<?= $user['entity_id'] ?>
                        <?php else: ?>
                            Не привязан
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($user['permissions'])): ?>
                            <span title="<?= implode(', ', $user['permissions']) ?>">
                                <?= count($user['permissions']) ?> прав
                            </span>
                        <?php else: ?>
                            Нет прав
                        <?php endif; ?>
                    </td>
                    <td><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="edit.php?id=<?= $user['user_id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                                <form action="delete.php" method="POST" class="inline-form"
                                    onsubmit="return confirm('Удалить пользователя?')">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../../templates/footer.php'; ?>