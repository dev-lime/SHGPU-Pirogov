<?php
require_once 'config/database.php';
require_once 'models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role_id = $_POST['role_id'] ?? 1;

    if (empty($username) || empty($password)) {
        $error = "Заполните все поля";
    } else {
        try {
            $con = getDBConnection();
            $hashedPassword = UserModel::hashPassword($password);

            $sql = "INSERT INTO users (username, password_hash, role_id) VALUES ($1, $2, $3)";
            $result = pg_query_params($con, $sql, [$username, $hashedPassword, $role_id]);

            if ($result) {
                $success = "Пользователь успешно создан";
            } else {
                $error = "Ошибка при создании пользователя";
            }
        } catch (Exception $e) {
            $error = "Ошибка: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <h2>Регистрация администратора</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
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
            <input type="hidden" name="role_id" value="1">
            <button type="submit" class="submit-btn">Зарегистрировать</button>
        </form>
        <p><a href="login.php" class="submit-btn">Войти в систему</a></p>
    </div>
</body>

</html>