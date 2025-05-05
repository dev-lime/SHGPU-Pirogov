<?php
require_once('config/database.php');
require_once 'models/ClientModel.php';
require_once 'models/DispatcherModel.php';
require_once 'models/DriverModel.php';
require_once 'models/VehicleModel.php';
require_once 'models/OrderModel.php';



/*if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ids'])) {
    $entityType = $_POST['entity_type'];
    $ids = $_POST['ids'];
    
    try {
        $con = getDBConnection();
        $placeholders = implode(',', array_fill(0, count($ids), '$%d'));
        
        // Безопасное формирование SQL-запроса
        $sql = "DELETE FROM $entityType WHERE {$entityType}_id IN ($placeholders)";
        $result = pg_query_params($con, $sql, $ids);
        
        if ($result) {
            header("Location: /index.php?success=entities_deleted&count=".count($ids));
        } else {
            header("Location: /index.php?error=delete_failed");
        }
    } catch (Exception $e) {
        header("Location: /index.php?error=".urlencode($e->getMessage()));
    }
} else {
    header("Location: /index.php");
}*/

if (isset($_GET['success'])) {
    $messages = [
        'client_created' => 'Клиент успешно создан',
        'dispatcher_created' => 'Диспетчер успешно создан',
        'driver_created' => 'Водитель успешно создан',
        'vehicle_created' => 'Транспортное средство успешно создано',
        'order_created' => 'Заказ успешно создан'
    ];
    if (isset($messages[$_GET['success']])) {
        echo '<div class="success-message">'.$messages[$_GET['success']].'</div>';
    }
}

if (isset($_GET['error'])) {
    echo '<div class="error-message">'.htmlspecialchars($_GET['error']).'</div>';
}

try {
    // Получаем данные из моделей
    $clients = ClientModel::getAllClients();
    $dispatchers = DispatcherModel::getAllDispatchers();
    $drivers = DriverModel::getAllDrivers();
    $vehicles = VehicleModel::getAllVehicles();
    $orders = OrderModel::getAllOrders();
    
    // Подключаем шапку
    require 'views/header.php';
    
    // Подключаем представления
    echo '<section id="clients">';
    require 'views/clients_view.php';
    echo '</section>';
    
    echo '<section id="dispatchers">';
    require 'views/dispatchers_view.php';
    echo '</section>';

    echo '<section id="drivers">';
    require 'views/drivers_view.php';
    echo '</section>';
    
    echo '<section id="vehicles">';
    require 'views/vehicles_view.php';
    echo '</section>';
    
    echo '<section id="orders">';
    require 'views/orders_view.php';
    echo '</section>';
    
    // Подключаем подвал
    require 'views/footer.php';
    
} catch (Exception $e) {
    // Обработка ошибок
    require 'views/header.php';
    echo '<p class="error">' . htmlspecialchars($e->getMessage()) . '</p>';
    require 'views/footer.php';
}

function getClientName($clientId, $clients) {
    foreach ($clients as $client) {
        if ($client['client_id'] == $clientId) {
            return htmlspecialchars($client['full_name']);
        }
    }
    return "Неизвестный клиент";
}

function getDispatcherName($dispatcherId, $dispatchers) {
    foreach ($dispatchers as $dispatcher) {
        if ($dispatcher['dispatcher_id'] == $dispatcherId) {
            return htmlspecialchars($dispatcher['full_name']);
        }
    }
    return "Неизвестный диспетчер";
}

function getDriverName($driverId, $drivers) {
    foreach ($drivers as $driver) {
        if ($driver['driver_id'] == $driverId) {
            return htmlspecialchars($driver['full_name']);
        }
    }
    return "Неизвестный водитель";
}

function getVehiclePlate($vehicleId, $vehicles) {
    foreach ($vehicles as $vehicle) {
        if ($vehicle['vehicle_id'] == $vehicleId) {
            return htmlspecialchars($vehicle['plate_number']);
        }
    }
    return "Неизвестный транспорт";
}

?>
