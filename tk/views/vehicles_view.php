<?php
$statusOptions = [
	['value' => 'available', 'display' => 'Доступен'],
	['value' => 'in_transit', 'display' => 'В рейсе'],
	['value' => 'maintenance', 'display' => 'На обслуживании']
];

$config = [
	'title' => 'Транспортные средства',
	'entityType' => 'vehicle',
	'primaryKey' => 'vehicle_id',
	'items' => $vehicles,
	'columns' => [
		['field' => 'vehicle_id', 'label' => 'ID'],
		['field' => 'plate_number', 'label' => 'Гос. номер'],
		['field' => 'model', 'label' => 'Модель'],
		['field' => 'capacity_kg', 'label' => 'Грузоподъемность (кг)'],
		['field' => 'status', 'label' => 'Статус'],
	],
	'fields' => [
		['name' => 'plate_number', 'label' => 'Гос. номер', 'type' => 'text', 'required' => true],
		['name' => 'model', 'label' => 'Модель', 'type' => 'text'],
		['name' => 'capacity_kg', 'label' => 'Грузоподъемность (кг)', 'type' => 'number', 'min' => 1],
		[
			'name' => 'status',
			'label' => 'Статус',
			'type' => 'select',
			'options' => $statusOptions,
			'valueField' => 'value',
			'displayField' => 'display'
		]
	]
];

require 'partials/table_template.php';
require 'partials/form_template.php';