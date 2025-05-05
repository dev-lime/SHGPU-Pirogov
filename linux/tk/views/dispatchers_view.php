<?php
$columns = [
    ['title' => 'ID', 'field' => 'dispatcher_id'],
    ['title' => 'ФИО', 'field' => 'full_name'],
    ['title' => 'Телефон', 'field' => 'phone'],
    ['title' => 'Email', 'field' => 'email']
];

$formFields = [
    ['name' => 'full_name', 'label' => 'ФИО', 'type' => 'text', 'required' => true],
    ['name' => 'phone', 'label' => 'Телефон', 'type' => 'text', 'required' => false],
    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => false]
];

renderTable($dispatchers, $columns, 'dispatchers');
renderCreateForm($formFields, '/tk/controllers/create_dispatcher.php');
?>
