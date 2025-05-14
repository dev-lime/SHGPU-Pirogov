<?php
$config = [
	'title' => 'Водители',
	'entityType' => 'driver',
	'primaryKey' => 'driver_id',
	'items' => $drivers ?? [],
	'columns' => [
		['field' => 'driver_id', 'label' => 'ID'],
		['field' => 'full_name', 'label' => 'ФИО'],
		['field' => 'license_number', 'label' => 'Номер лицензии'],
		['field' => 'phone', 'label' => 'Телефон'],
	],
	'fields' => [
		['name' => 'full_name', 'label' => 'ФИО', 'type' => 'text', 'required' => true],
		['name' => 'license_number', 'label' => 'Номер лицензии', 'type' => 'text', 'required' => true],
		['name' => 'phone', 'label' => 'Телефон', 'type' => 'text'],
	]
];

require 'partials/table_template.php';
require 'partials/form_template.php';