<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/ClientModel.php';

requireAuth();
requirePermission('create_all');

$pageTitle = 'Создание клиента';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $con = getDBConnection();

        $data = [
            'full_name' => trim($_POST['full_name']),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'company_name' => trim($_POST['company_name'] ?? '')
        ];

        $result = ClientModel::create($con, $data);

        if ($result) {
            header("Location: index.php?success=client_created");
            exit;
        } else {
            $error = "Ошибка при создании клиента";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

require '../../templates/header.php';
?>

<div class="page-header">
    <h1>Создание клиента</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="POST" class="form-container">
    <div class="form-group">
        <label for="full_name">ФИО *</label>
        <input type="text" id="full_name" name="full_name" required>
    </div>

    <div class="form-group">
        <label for="phone">Телефон</label>
        <input type="tel" id="phone" name="phone">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
    </div>

    <div class="form-group">
        <label for="company_name">Компания</label>
        <input type="text" id="company_name" name="company_name">
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Создать
        </button>
        <a href="index.php" class="btn btn-secondary">Отмена</a>
    </div>
</form>

<style>
    .form-container {
        max-width: 600px;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: var(--dark);
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-group input:focus {
        border-color: var(--primary);
        outline: none;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .alert {
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-error {
        background: #ffebee;
        color: #d32f2f;
        border: 1px solid #f44336;
    }
</style>

<?php require '../../templates/footer.php'; ?>