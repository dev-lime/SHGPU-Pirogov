<?php
$config = [
	'title' => 'Диспетчеры',
	'entityType' => 'dispatcher',
	'primaryKey' => 'dispatcher_id',
	'items' => $dispatchers ?? [],
	'columns' => [
		['field' => 'dispatcher_id', 'label' => 'ID'],
		['field' => 'full_name', 'label' => 'ФИО'],
		['field' => 'phone', 'label' => 'Телефон'],
		['field' => 'email', 'label' => 'Email'],
	],
	'fields' => [
		['name' => 'full_name', 'label' => 'ФИО', 'type' => 'text', 'required' => true],
		['name' => 'phone', 'label' => 'Телефон', 'type' => 'text'],
		['name' => 'email', 'label' => 'Email', 'type' => 'email'],
	]
];

require 'partials/table_template.php';
require 'partials/form_template.php';