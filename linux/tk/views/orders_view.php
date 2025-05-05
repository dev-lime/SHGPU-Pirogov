<?php
// views/orders_view.php
$columns = [
    ['title' => 'ID', 'field' => 'order_id'],
    ['title' => 'Клиент', 'field' => 'client_id', 'format' => function($value) use ($clients) {
        return getEntityName($value, $clients);
    }],
    ['title' => 'Откуда', 'field' => 'origin'],
    ['title' => 'Куда', 'field' => 'destination'],
    ['title' => 'Дата доставки', 'field' => 'delivery_date']
];

$formFields = [
    [
        'name' => 'client_id', 
        'label' => 'Клиент', 
        'type' => 'select', 
        'required' => true,
        'options' => array_map(function($client) {
            return ['value' => $client['client_id'], 'text' => $client['full_name']];
        }, $clients)
    ],
    // остальные поля формы
];

renderTable($orders, $columns, 'orders');
renderCreateForm($formFields, '/tk/controllers/create_order.php');
?>
