<?php
$clientOptions = array_map(function ($client) {
	return [
		'value' => $client['client_id'],
		'display' => $client['full_name']
	];
}, $clients ?? []);

$dispatcherOptions = array_map(function ($dispatcher) {
	return [
		'value' => $dispatcher['dispatcher_id'],
		'display' => $dispatcher['full_name']
	];
}, $dispatchers ?? []);

$driverOptions = array_map(function ($driver) {
	return [
		'value' => $driver['driver_id'],
		'display' => $driver['full_name']
	];
}, $drivers ?? []);

$vehicleOptions = array_map(function ($vehicle) {
	return [
		'value' => $vehicle['vehicle_id'],
		'display' => $vehicle['plate_number']
	];
}, $vehicles ?? []);

$config = [
	'title' => 'Заказы',
	'entityType' => 'order',
	'primaryKey' => 'order_id',
	'items' => $orders ?? [],
	'columns' => [
		['field' => 'order_id', 'label' => 'ID'],
		[
			'field' => 'client_id',
			'label' => 'Клиент',
			'link' => [
				'entities' => 'clients',
				'idField' => 'client_id',
				'nameField' => 'full_name',
				'entityType' => 'client'
			]
		],
		[
			'field' => 'dispatcher_id',
			'label' => 'Диспетчер',
			'link' => [
				'entities' => 'dispatchers',
				'idField' => 'dispatcher_id',
				'nameField' => 'full_name',
				'entityType' => 'dispatcher'
			]
		],
		[
			'field' => 'driver_id',
			'label' => 'Водитель',
			'link' => [
				'entities' => 'drivers',
				'idField' => 'driver_id',
				'nameField' => 'full_name',
				'entityType' => 'driver'
			]
		],
		[
			'field' => 'vehicle_id',
			'label' => 'Транспорт',
			'link' => [
				'entities' => 'vehicles',
				'idField' => 'vehicle_id',
				'nameField' => 'plate_number',
				'entityType' => 'vehicle'
			]
		],
		['field' => 'origin', 'label' => 'Откуда'],
		['field' => 'destination', 'label' => 'Куда'],
		['field' => 'cargo_description', 'label' => 'Груз'],
		['field' => 'weight_kg', 'label' => 'Вес (кг)'],
		['field' => 'status', 'label' => 'Статус'],
		['field' => 'created_at', 'label' => 'Дата создания'],
		['field' => 'delivery_date', 'label' => 'Дата доставки'],
	],
	'fields' => [
		[
			'name' => 'client_id',
			'label' => 'Клиент',
			'type' => 'select',
			'options' => $clientOptions,
			'valueField' => 'value',
			'displayField' => 'display',
			'required' => true
		],
		[
			'name' => 'dispatcher_id',
			'label' => 'Диспетчер',
			'type' => 'select',
			'options' => $dispatcherOptions,
			'valueField' => 'value',
			'displayField' => 'display',
			'required' => true
		],
		[
			'name' => 'driver_id',
			'label' => 'Водитель',
			'type' => 'select',
			'options' => $driverOptions,
			'valueField' => 'value',
			'displayField' => 'display',
			'required' => true
		],
		[
			'name' => 'vehicle_id',
			'label' => 'Транспорт',
			'type' => 'select',
			'options' => $vehicleOptions,
			'valueField' => 'value',
			'displayField' => 'display',
			'required' => true
		],
		['name' => 'origin', 'label' => 'Откуда', 'type' => 'text', 'required' => true],
		['name' => 'destination', 'label' => 'Куда', 'type' => 'text', 'required' => true],
		['name' => 'cargo_description', 'label' => 'Описание груза', 'type' => 'textarea'],
		['name' => 'weight_kg', 'label' => 'Вес (кг)', 'type' => 'number', 'min' => 1],
		['name' => 'delivery_date', 'label' => 'Дата доставки', 'type' => 'date'],
	]
];

require 'partials/table_template.php';
require 'partials/form_template.php';