<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';
require_once '../../models/ClientModel.php';

requireAuth();
requirePermission('delete_all');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$clientId = $_POST['client_id'] ?? null;

if (!$clientId) {
    header("Location: index.php?error=client_id_required");
    exit;
}

try {
    $con = getDBConnection();
    $result = ClientModel::delete($con, [$clientId]);

    if ($result) {
        header("Location: index.php?success=client_deleted");
    } else {
        header("Location: index.php?error=client_delete_failed");
    }
} catch (Exception $e) {
    header("Location: index.php?error=" . urlencode($e->getMessage()));
}
?>