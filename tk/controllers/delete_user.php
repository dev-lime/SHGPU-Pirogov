<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../utils/auth.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /tk/index.php");
    exit;
}

$userId = $_POST['user_id'] ?? null;

if (!$userId) {
    header("Location: /tk/index.php?error=user_id_required");
    exit;
}

try {
    $con = getDBConnection();

    if ($userId == $_SESSION['user_id']) {
        header("Location: /tk/index.php?error=cannot_delete_yourself");
        exit;
    }

    $result = UserModel::delete($con, [$userId]);

    if ($result) {
        header("Location: /tk/index.php?success=user_deleted");
    } else {
        header("Location: /tk/index.php?error=user_delete_failed");
    }
} catch (Exception $e) {
    header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
}
?>