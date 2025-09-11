<?php
require_once '../utils/auth.php';
requirePermission('update_order_status');

// Проверяем, может ли пользователь обновлять этот заказ
if (getUserRole() === 'driver') {
	// Для водителя проверяем, что заказ назначен на него
	$con = getDBConnection();
	$checkSql = "SELECT driver_id FROM orders WHERE order_id = $1";
	$result = pg_query_params($con, $checkSql, [$orderId]);
	$driverId = pg_fetch_result($result, 0, 0);

	if ($driverId != $_SESSION['entity_id']) {
		header("Location: /tk/index.php?error=access_denied");
		exit;
	}
}

require_once '../config/database.php';
require_once '../models/OrderModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header("Location: /tk/index.php");
	exit;
}

$orderId = $_POST['order_id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$orderId || !in_array($status, ['picked_up', 'delivered'])) {
	header("Location: /tk/index.php?error=invalid_parameters");
	exit;
}

try {
	$con = getDBConnection();

	// Проверка текущего статуса для соблюдения последовательности
	$checkSql = "SELECT status FROM orders WHERE order_id = $1";
	$result = pg_query_params($con, $checkSql, [$orderId]);
	$currentStatus = pg_fetch_result($result, 0, 0);

	if ($status === 'delivered' && $currentStatus !== 'picked_up') {
		header("Location: /tk/index.php?error=cannot_deliver_not_picked_up");
		exit;
	}

	// Человекочитаемое название статуса
	$statusName = $status === 'picked_up' ? 'забран со склада' : 'доставлен';

	if (OrderModel::updateStatus($con, $orderId, $status)) {
		header("Location: /tk/index.php?success=order_status_updated&status=" . urlencode($statusName));
	} else {
		header("Location: /tk/index.php?error=status_update_failed");
	}
} catch (Exception $e) {
	header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
}
?>