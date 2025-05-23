<?php
require_once('config/database.php');
require_once('utils/entity_utils.php');

// Настройка отображения ошибок для разработки
error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
	$file = __DIR__ . '/models/' . $class . '.php';
	if (file_exists($file)) {
		require $file;
	} else {
		throw new Exception("Не удалось загрузить класс: $class");
	}
});

// Сообщения об успешных операциях
$messages = [
	'client_created' => 'Клиент успешно создан',
	'dispatcher_created' => 'Диспетчер успешно создан',
	'driver_created' => 'Водитель успешно создан',
	'vehicle_created' => 'Транспортное средство успешно создано',
	'order_created' => 'Заказ успешно создан',
	'records_deleted' => 'Записи успешно удалены'
];

// Вывод сообщений
function showMessage($type, $content)
{
	echo '<div class="' . $type . '-message">' . htmlspecialchars($content) . '</div>';
}

if (isset($_GET['success'])) {
	if (isset($messages[$_GET['success']])) {
		showMessage('success', $messages[$_GET['success']]);
	}
}

if (isset($_GET['error'])) {
	showMessage('error', $_GET['error']);
}

try {
	// Получаем параметры фильтрации из GET-запроса
	$filters = [
		'clients' => $_GET['client_filter'] ?? [],
		'dispatchers' => $_GET['dispatcher_filter'] ?? [],
		'drivers' => $_GET['driver_filter'] ?? [],
		'vehicles' => $_GET['vehicle_filter'] ?? [],
		'orders' => $_GET['order_filter'] ?? []
	];

	// Загрузка данных с фильтрами
	$data = [
		'clients' => ClientModel::getAll($filters['clients']),
		'dispatchers' => DispatcherModel::getAll($filters['dispatchers']),
		'drivers' => DriverModel::getAll($filters['drivers']),
		'vehicles' => VehicleModel::getAll($filters['vehicles']),
		'orders' => OrderModel::getAll($filters['orders'])
	];

	// Проверка данных
	foreach ($data as $key => $value) {
		if (!is_array($value)) {
			throw new Exception("Ошибка загрузки данных: $key");
		}
	}

	// Подготовка данных для представлений
	extract($data);

	// Загрузка шаблонов
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

		// Проверяем существование файла представления
		$viewPath = 'views/' . $view;
		if (!file_exists($viewPath)) {
			throw new Exception("Файл представления не найден: $viewPath");
		}

		// Передаем все данные в представление
		require $viewPath;
		echo '</section>';
	}

	require 'views/footer.php';

} catch (Exception $e) {
	// Обработка ошибок с выводом деталей
	require 'views/header.php';
	echo '<div class="error">';
	echo '<h2>Произошла ошибка</h2>';
	echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';

	// Дополнительная отладочная информация
	if (ini_get('display_errors')) {
		echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
	}

	echo '</div>';
	require 'views/footer.php';
}