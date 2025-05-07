<?php
require_once '../config/database.php';
require_once '../models/VehicleModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = [
		'plate_number' => $_POST['plate_number'],
		'model' => $_POST['model'] ?? null,
		'capacity_kg' => $_POST['capacity_kg'] ?? null,
		'status' => $_POST['status'] ?? 'available'
	];

	try {
		$con = getDBConnection();
		$result = VehicleModel::createVehicle($con, $data);

		header("Location: /tk/index.php?success=vehicle_created");
	} catch (Exception $e) {
		header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
	}
} else {
	header("Location: /tk/index.php");
}
