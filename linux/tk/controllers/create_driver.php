<?php
require_once '../config/database.php';
require_once '../models/DriverModel.php';
require_once 'BaseController.php';

class CreateDriverController extends BaseController {
    protected static $modelClass = 'DriverModel';
    protected static $successMessage = 'driver_created';
    
    protected static function prepareData($postData) {
        return [
            'full_name' => $postData['full_name'],
            'license_number' => $postData['license_number'],
            'phone' => $postData['phone'] ?? null
        ];
    }
}

CreateDriverController::handleCreate();
?>
