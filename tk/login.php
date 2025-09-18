<?php
require_once 'config/database.php';
require_once 'models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $user = UserModel::findByUsername($username);

        if ($user && UserModel::verifyPassword($password, $user['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role_name'];
            $_SESSION['permissions'] = $user['permissions'] ?? [];
            $_SESSION['entity_id'] = $user['entity_id'];
            $_SESSION['entity_type'] = $user['entity_type'];

            header("Location: /tk/index.php");
            exit;
        } else {
            $error = "Неверное имя пользователя или пароль";
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
    <title>Вход в систему</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <h2>Вход в систему</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Имя пользователя:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Пароль:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Войти</button>
        </form>
        <p><a href="register.php" class="submit-btn">Регистрация</a></p>
    </div>
</body>

</html>