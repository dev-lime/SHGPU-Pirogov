<?php
$config = [
	'title' => 'Клиенты',
	'entityType' => 'client',
	'primaryKey' => 'client_id',
	'items' => $clients,
	'columns' => [
		['field' => 'client_id', 'label' => 'ID'],
		['field' => 'full_name', 'label' => 'ФИО'],
		['field' => 'phone', 'label' => 'Телефон'],
		['field' => 'email', 'label' => 'Email'],
		['field' => 'company_name', 'label' => 'Компания'],
	],
	'fields' => [
		['name' => 'full_name', 'label' => 'ФИО', 'type' => 'text', 'required' => true],
		['name' => 'phone', 'label' => 'Телефон', 'type' => 'text'],
		['name' => 'email', 'label' => 'Email', 'type' => 'email'],
		['name' => 'company_name', 'label' => 'Компания', 'type' => 'text'],
	]
];

require 'partials/table_template.php';
require 'partials/form_template.php';