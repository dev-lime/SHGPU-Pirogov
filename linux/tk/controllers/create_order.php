<?php
require_once '../config/database.php';
require_once '../models/OrderModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'client_id' => $_POST['client_id'],
        'dispatcher_id' => $_POST['dispatcher_id'] ?? null,
        'driver_id' => $_POST['driver_id'] ?? null,
        'vehicle_id' => $_POST['vehicle_id'] ?? null,
        'origin' => $_POST['origin'],
        'destination' => $_POST['destination'],
        'cargo_description' => $_POST['cargo_description'] ?? null,
        'weight_kg' => $_POST['weight_kg'] ?? null,
        'delivery_date' => $_POST['delivery_date'] ?? null
    ];
    
    try {
        $con = getDBConnection();
        $result = OrderModel::createOrder($con, $data);
        
        header("Location: /tk/index.php?success=order_created");
    } catch (Exception $e) {
        header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: /tk/index.php");
}
