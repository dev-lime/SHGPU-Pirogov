<?php
require_once '../config/database.php';
require_once '../models/ClientModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = [
		'full_name' => $_POST['full_name'],
		'phone' => $_POST['phone'] ?? null,
		'email' => $_POST['email'] ?? null,
		'company_name' => $_POST['company_name'] ?? null
	];

	try {
		$con = getDBConnection();
		$result = ClientModel::createClient($con, $data);

		if ($result) {
			header("Location: /tk/index.php?success=client_created");
		} else {
			header("Location: /tk/index.php?error=client_create_failed");
		}
	} catch (Exception $e) {
		header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
	}
} else {
	header("Location: /tk/index.php");
}
