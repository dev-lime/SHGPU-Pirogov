<?php
require_once 'config/database.php';
require_once 'models/ClientModel.php';
require_once 'models/DispatcherModel.php';
require_once 'models/DriverModel.php';
require_once 'models/VehicleModel.php';
require_once 'models/OrderModel.php';

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
?>
