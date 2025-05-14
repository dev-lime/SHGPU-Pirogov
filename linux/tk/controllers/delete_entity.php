<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header("Location: /tk/index.php");
	exit;
}

$entityTypes = [
	'client' => ['model' => 'ClientModel'],
	'dispatcher' => ['model' => 'DispatcherModel'],
	'driver' => ['model' => 'DriverModel'],
	'vehicle' => ['model' => 'VehicleModel'],
	'order' => ['model' => 'OrderModel']
];

$entityType = $_POST['entity_type'] ?? '';
if (!isset($entityTypes[$entityType])) {
	header("Location: /tk/index.php?error=invalid_entity_type");
	exit;
}

$modelClass = $entityTypes[$entityType]['model'];
require_once "../models/{$modelClass}.php";

try {
	$con = getDBConnection();
	$ids = $_POST['ids'] ?? [];

	if (empty($ids)) {
		header("Location: /tk/index.php?error=" . urlencode("Не выбраны записи для удаления"));
		exit;
	}

	$result = $modelClass::delete($con, $ids);

	if ($result) {
		header("Location: /tk/index.php?success=records_deleted");
	} else {
		header("Location: /tk/index.php?error=" . urlencode("Ошибка при удалении записей"));
	}
} catch (Exception $e) {
	header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
}