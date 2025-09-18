<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../utils/auth.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /tk/index.php");
    exit;
}

try {
    $con = getDBConnection();

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $roleId = (int) ($_POST['role_id'] ?? 0);
    $entityType = trim($_POST['entity_type'] ?? '');
    $entityId = trim($_POST['entity_id'] ?? '');

    if (empty($username) || empty($password) || empty($roleId)) {
        throw new Exception("Все обязательные поля должны быть заполнены");
    }

    $checkSql = "SELECT COUNT(*) FROM users WHERE username = $1";
    $result = pg_query_params($con, $checkSql, [$username]);
    $count = pg_fetch_result($result, 0, 0);

    if ($count > 0) {
        throw new Exception("Пользователь с таким логином уже существует");
    }

    $passwordHash = UserModel::hashPassword($password);

    $data = [
        'username' => $username,
        'password_hash' => $passwordHash,
        'role_id' => $roleId
    ];

    if (!empty($entityType) && !empty($entityId)) {
        $data['entity_type'] = $entityType;
        $data['entity_id'] = (int) $entityId;
    }

    $columns = implode(', ', array_keys($data));
    $placeholders = '$' . implode(', $', range(1, count($data)));

    $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";
    $result = pg_query_params($con, $sql, array_values($data));

    if ($result) {
        header("Location: /tk/index.php?success=user_created");
    } else {
        $error = pg_last_error($con);
        throw new Exception("Ошибка при создании пользователя: " . $error);
    }
} catch (Exception $e) {
    header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
}
?>