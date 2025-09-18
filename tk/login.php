<?php
require_once 'config/database.php';
require_once 'models/UserModel.php';
require_once 'utils/helpers.php';

session_start();

// Если пользователь уже авторизован, перенаправляем на главную
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    try {
        $user = UserModel::findByUsername($username);

        if ($user && UserModel::verifyPassword($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role_name'];
            $_SESSION['permissions'] = $user['permissions'] ?? [];
            $_SESSION['entity_id'] = $user['entity_id'];
            $_SESSION['entity_type'] = $user['entity_type'];

            // Логируем вход
            logAction('login', ['username' => $username], $user['user_id']);

            header("Location: index.php");
            exit;
        } else {
            $error = "Неверное имя пользователя или пароль";
            logAction('failed_login', ['username' => $username, 'ip' => $_SERVER['REMOTE_ADDR']]);
        }
    } catch (Exception $e) {
        $error = "Ошибка авторизации: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - ТК Логистик</title>
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
                <p>Войдите в свою учетную запись</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="username" placeholder="Имя пользователя" required
                        value="<?= e($_POST['username'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Войти
                </button>
            </form>

            <div class="login-footer">
                <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
                <p><a href="forgot-password.php">Забыли пароль?</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.querySelector('input[name="password"]');
            const eyeIcon = document.querySelector('.toggle-password i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'fas fa-eye';
            }
        }

        // Фокус на поле ввода при загрузке
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('input[name="username"]').focus();
        });
    </script>
</body>

</html>