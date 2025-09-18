<?php
require_once 'config/database.php';
require_once 'models/ClientModel.php';
require_once 'models/UserModel.php';
require_once 'utils/helpers.php';

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $con = getDBConnection();

        $data = [
            'full_name' => trim($_POST['full_name']),
            'phone' => trim($_POST['phone']),
            'email' => trim($_POST['email']),
            'company_name' => trim($_POST['company_name'] ?? '')
        ];

        // Валидация
        if (empty($data['full_name']) || empty($data['phone']) || empty($data['email'])) {
            throw new Exception("Все обязательные поля должны быть заполнены");
        }

        if (!isValidEmail($data['email'])) {
            throw new Exception("Некорректный email адрес");
        }

        if ($_POST['password'] !== $_POST['confirm_password']) {
            throw new Exception("Пароли не совпадают");
        }

        // Создаем клиента
        $clientId = ClientModel::create($con, $data);

        if (!$clientId) {
            throw new Exception("Ошибка при создании клиента");
        }

        // Создаем пользователя
        $userData = [
            'username' => trim($_POST['email']),
            'password_hash' => UserModel::hashPassword(trim($_POST['password'])),
            'role_id' => 4, // Роль client
            'entity_type' => 'client',
            'entity_id' => $clientId
        ];

        $userId = UserModel::create($con, $userData);

        if ($userId) {
            $success = "Регистрация успешна! Теперь вы можете войти в систему.";
            logAction('registration', ['email' => $data['email'], 'client_id' => $clientId]);
        } else {
            throw new Exception("Ошибка при создании пользователя");
        }

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - ТК Логистик</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-truck"></i>
                    <h1>ТК Логистик</h1>
                </div>
                <p>Создайте учетную запись клиента</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= e($success) ?>
                    <p><a href="login.php" class="btn-link">Войти в систему</a></p>
                </div>
            <?php else: ?>

                <form method="POST" class="login-form">
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="full_name" placeholder="ФИО *" required 
                               value="<?= e($_POST['full_name'] ?? '') ?>">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" name="phone" placeholder="Телефон *" required 
                               value="<?= e($_POST['phone'] ?? '') ?>">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" placeholder="Email *" required 
                               value="<?= e($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-building input-icon"></i>
                        <input type="text" name="company_name" placeholder="Компания (необязательно)" 
                               value="<?= e($_POST['company_name'] ?? '') ?>">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" placeholder="Пароль *" required>
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="confirm_password" placeholder="Подтверждение пароля *" required>
                    </div>

                    <button type="submit" class="login-btn">
                        <i class="fas fa-user-plus"></i>
                        Зарегистрироваться
                    </button>
                </form>

            <?php endif; ?>

            <div class="login-footer">
                <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
            </div>
        </div>
    </div>
</body>
</html>