<?php
require_once '../config/database.php';
require_once '../models/DriverModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => $_POST['full_name'],
        'license_number' => $_POST['license_number'],
        'phone' => $_POST['phone'] ?? null
    ];
    
    try {
        $con = getDBConnection();
        $result = DriverModel::createDriver($con, $data);
        
        header("Location: /tk/index.php?success=driver_created");
    } catch (Exception $e) {
        header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: /tk/index.php");
}
