<?php
require_once '../config/database.php';
require_once '../models/UserModel.php';
require_once '../utils/auth.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /tk/index.php");
    exit;
}

try {
    $con = getDBConnection();

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $roleId = $_POST['role_id'] ?? '';
    $entityType = $_POST['entity_type'] ?? null;
    $entityId = $_POST['entity_id'] ?? null;

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
        'role_id' => $roleId,
        'entity_type' => $entityType ?: null,
        'entity_id' => $entityId ?: null
    ];

    $data = array_filter($data, function ($value) {
        return $value !== null && $value !== '';
    });

    $result = UserModel::create($con, $data);

    if ($result) {
        header("Location: /tk/index.php?success=user_created");
    } else {
        throw new Exception("Ошибка при создании пользователя");
    }
} catch (Exception $e) {
    header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
}
?>