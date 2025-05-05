<?php
require_once '../config/database.php';
require_once '../models/DispatcherModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => $_POST['full_name'],
        'phone' => $_POST['phone'] ?? null,
        'email' => $_POST['email'] ?? null
    ];
    
    try {
        $con = getDBConnection();
        $result = DispatcherModel::createDispatcher($con, $data);
        
        if ($result) {
            header("Location: /tk/index.php?success=dispatcher_created");
        } else {
            header("Location: /tk/index.php?error=dispatcher_create_failed");
        }
    } catch (Exception $e) {
        header("Location: /tk/index.php?error=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: /tk/index.php");
}
?>
