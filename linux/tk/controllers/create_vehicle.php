<?php
require_once '../config/database.php';
require_once '../models/VehicleModel.php';
require_once 'BaseController.php';

class CreateVehicleController extends BaseController {
    protected static $modelClass = 'VehicleModel';
    protected static $successMessage = 'vehicle_created';
    
    protected static function prepareData($postData) {
        return [
            'plate_number' => $postData['plate_number'],
            'model' => $postData['model'] ?? null,
            'capacity_kg' => $postData['capacity_kg'] ?? null,
            'status' => $postData['status'] ?? 'available'
        ];
    }
}

CreateVehicleController::handleCreate();
?>
