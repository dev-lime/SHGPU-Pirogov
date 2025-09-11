<?php
require_once '../utils/auth.php';
requirePermission('create_all');

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header("Location: /tk/index.php");
	exit;
}

$entityTypes = [
	'client' => ['model' => 'ClientModel', 'success' => 'client_created'],
	'dispatcher' => ['model' => 'DispatcherModel', 'success' => 'dispatcher_created'],
	'driver' => ['model' => 'DriverModel', 'success' => 'driver_created'],
	'vehicle' => ['model' => 'VehicleModel', 'success' => 'vehicle_created'],
	'order' => ['model' => 'OrderModel', 'success' => 'order_created']
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
	$data = $_POST;
	unset($data['entity_type']); // Удаляет служебное поле

	$result = $modelClass::create($con, $data);

	if ($result) {
		header("Location: /tk/index.php?success=" . $entityTypes[$entityType]['success']);
	} else {
		header("Location: /tk/index.php?error=" . urlencode("Ошибка при создании записи"));
	}
} catch (Exception $e) {
	header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
}
?>