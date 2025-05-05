<?php
require_once '../config/database.php';
require_once '../models/OrderModel.php';
require_once 'BaseController.php';

class CreateOrderController extends BaseController {
    protected static $modelClass = 'OrderModel';
    protected static $successMessage = 'order_created';
    
    protected static function prepareData($postData) {
        return [
            'client_id' => $postData['client_id'],
            'dispatcher_id' => $postData['dispatcher_id'] ?? null,
            'driver_id' => $postData['driver_id'] ?? null,
            'vehicle_id' => $postData['vehicle_id'] ?? null,
            'origin' => $postData['origin'],
            'destination' => $postData['destination'],
            'cargo_description' => $postData['cargo_description'] ?? null,
            'weight_kg' => $postData['weight_kg'] ?? null,
            'delivery_date' => $postData['delivery_date'] ?? null
        ];
    }
}

CreateOrderController::handleCreate();
?>
