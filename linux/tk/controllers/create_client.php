<?php
require_once '../config/database.php';
require_once '../models/ClientModel.php';
require_once 'BaseController.php';

class CreateClientController extends BaseController {
    protected static $modelClass = 'ClientModel';
    protected static $successMessage = 'client_created';
    
    protected static function prepareData($postData) {
        return [
            'full_name' => $postData['full_name'],
            'phone' => $postData['phone'] ?? null,
            'email' => $postData['email'] ?? null,
            'company_name' => $postData['company_name'] ?? null
        ];
    }
}

CreateClientController::handleCreate();
?>
