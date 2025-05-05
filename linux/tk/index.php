<?php
require_once('config/database.php');
require_once 'models/ClientModel.php';
require_once 'models/DispatcherModel.php';
require_once 'models/DriverModel.php';
require_once 'models/VehicleModel.php';
require_once 'models/OrderModel.php';

$messages = [
    'client_created' => 'Клиент успешно создан',
    'dispatcher_created' => 'Диспетчер успешно создан',
    'driver_created' => 'Водитель успешно создан',
    'vehicle_created' => 'Транспортное средство успешно создано',
    'order_created' => 'Заказ успешно создан'
];

function showMessage($type, $messages) {
    if (isset($_GET[$type]) {
        $key = $_GET[$type];
        if (isset($messages[$key])) {
            $class = $type === 'success' ? 'success-message' : 'error-message';
            $message = $type === 'success' ? $messages[$key] : htmlspecialchars($key);
            echo "<div class=\"$class\">$message</div>";
        }
    }
}

function getEntityName($entityId, $entities, $field = 'full_name') {
    foreach ($entities as $entity) {
        $idField = current($entities) . '_id';
        if ($entity[$idField] == $entityId) {
            return htmlspecialchars($entity[$field]);
        }
    }
    return "Неизвестный элемент";
}

try {
    $models = [
        'clients' => ClientModel::getAll(),
        'dispatchers' => DispatcherModel::getAll(),
        'drivers' => DriverModel::getAll(),
        'vehicles' => VehicleModel::getAll(),
        'orders' => OrderModel::getAll()
    ];
    
    require 'views/header.php';
    showMessage('success', $messages);
    showMessage('error', []);
    
    foreach ($models as $section => $data) {
        echo "<section id=\"$section\">";
        require "views/{$section}_view.php";
        echo '</section>';
    }
    
    require 'views/footer.php';
} catch (Exception $e) {
    require 'views/header.php';
    echo '<div class="error-message">' . htmlspecialchars($e->getMessage()) . '</div>';
    require 'views/footer.php';
}
?>
