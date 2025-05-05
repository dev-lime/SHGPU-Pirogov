<?php
$columns = [
    ['title' => 'ID', 'field' => 'client_id'],
    ['title' => 'ФИО', 'field' => 'full_name'],
    ['title' => 'Телефон', 'field' => 'phone'],
    ['title' => 'Email', 'field' => 'email'],
    ['title' => 'Компания', 'field' => 'company_name']
];

$formFields = [
    ['name' => 'full_name', 'label' => 'ФИО', 'type' => 'text', 'required' => true],
    ['name' => 'phone', 'label' => 'Телефон', 'type' => 'text', 'required' => false],
    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => false],
    ['name' => 'company_name', 'label' => 'Компания', 'type' => 'text', 'required' => false]
];

renderTable($clients, $columns, 'clients');
renderCreateForm($formFields, '/tk/controllers/create_client.php');
?>
