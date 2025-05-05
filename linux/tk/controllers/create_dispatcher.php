<?php
require_once '../config/database.php';
require_once '../models/DispatcherModel.php';
require_once 'BaseController.php';

class CreateDispatcherController extends BaseController {
    protected static $modelClass = 'DispatcherModel';
    protected static $successMessage = 'dispatcher_created';
    
    protected static function prepareData($postData) {
        return [
            'full_name' => $postData['full_name'],
            'phone' => $postData['phone'] ?? null,
            'email' => $postData['email'] ?? null
        ];
    }
}

CreateDispatcherController::handleCreate();
?>
