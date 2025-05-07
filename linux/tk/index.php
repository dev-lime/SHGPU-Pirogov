<?php
require_once('config/database.php');
require_once('utils/entity_utils.php');

spl_autoload_register(function ($class) {
	$file = __DIR__ . '/models/' . $class . '.php';
	if (file_exists($file)) {
		require $file;
	}
});

$messages = [
	'client_created' => 'Клиент успешно создан',
	'dispatcher_created' => 'Диспетчер успешно создан',
	'driver_created' => 'Водитель успешно создан',
	'vehicle_created' => 'Транспортное средство успешно создано',
	'order_created' => 'Заказ успешно создан'
];

if (isset($_GET['success'])) {
	if (isset($messages[$_GET['success']])) {
		echo '<div class="success-message">' . $messages[$_GET['success']] . '</div>';
	}
}

if (isset($_GET['error'])) {
	echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
}

try {
	// Данные из моделей
	$clients = ClientModel::getAll();
	$dispatchers = DispatcherModel::getAll();
	$drivers = DriverModel::getAll();
	$vehicles = VehicleModel::getAll();
	$orders = OrderModel::getAll();

	// Разметка сайта
	require 'views/header.php';

	$sections = [
		'clients' => 'clients_view.php',
		'dispatchers' => 'dispatchers_view.php',
		'drivers' => 'drivers_view.php',
		'vehicles' => 'vehicles_view.php',
		'orders' => 'orders_view.php'
	];

	foreach ($sections as $id => $view) {
		echo '<section id="' . $id . '">';
		require 'views/' . $view;
		echo '</section>';
	}

	require 'views/footer.php';

} catch (Exception $e) {
	require 'views/header.php';
	echo '<p class="error">' . htmlspecialchars($e->getMessage()) . '</p>';
	require 'views/footer.php';
}
?>