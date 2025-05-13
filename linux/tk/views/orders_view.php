<?php
$config = [
	'title' => 'Заказы',
	'entityType' => 'order',
	'primaryKey' => 'order_id',
	'items' => $orders,
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
			'required' => true,
			'options' => 'clients',
			'valueField' => 'client_id',
			'displayField' => 'full_name'
		],
		[
			'name' => 'dispatcher_id',
			'label' => 'Диспетчер',
			'type' => 'select',
			'options' => 'dispatchers',
			'valueField' => 'dispatcher_id',
			'displayField' => 'full_name'
		],
		[
			'name' => 'driver_id',
			'label' => 'Водитель',
			'type' => 'select',
			'options' => 'drivers',
			'valueField' => 'driver_id',
			'displayField' => 'full_name'
		],
		[
			'name' => 'vehicle_id',
			'label' => 'Транспорт',
			'type' => 'select',
			'options' => 'vehicles',
			'valueField' => 'vehicle_id',
			'displayField' => 'plate_number'
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