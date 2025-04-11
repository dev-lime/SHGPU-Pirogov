<?php
error_reporting(0);

print "<html>";
print "<head>";
print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
print "<title>Транспортная компания - База данных</title>";
print "<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
        background-color: #f5f5f5;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }
    h1, h2 {
        color: #2c3e50;
        text-align: center;
    }
    h2 {
        margin-top: 40px;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        box-shadow: 0 2px 3px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #3498db;
        color: white;
        font-weight: bold;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #e3f2fd;
    }
    .count {
        font-style: italic;
        color: #7f8c8d;
        text-align: right;
    }
    .error {
        color: #e74c3c;
        font-weight: bold;
    }
</style>";
print "</head>";
print "<body>";
print "<div class='container'>";
print "<h1>База данных транспортной компании</h1>";

$con = pg_connect('host=localhost port=5432 dbname=tk user=postgres password=123');
if (!$con) {
    print "<p class='error'>Ошибка подключения к базе данных</p>";
} else {
    // Таблица clients
    display_table($con, "clients", "Клиенты", ["client_id", "full_name", "phone", "email", "company_name"]);
    
    // Таблица dispatchers
    display_table($con, "dispatchers", "Диспетчеры", ["dispatcher_id", "full_name", "phone", "email"]);
    
    // Таблица drivers
    display_table($con, "drivers", "Водители", ["driver_id", "full_name", "license_number", "phone"]);
    
    // Таблица vehicles
    display_table($con, "vehicles", "Транспорт", ["vehicle_id", "plate_number", "model", "capacity_kg", "status"]);
    
    // Таблица orders
    display_table($con, "orders", "Заказы", ["order_id", "client_id", "dispatcher_id", "driver_id", "vehicle_id", 
                                           "origin", "destination", "cargo_description", "weight_kg", "status", 
                                           "created_at", "delivery_date"]);
    
    pg_close($con);
}

print "</div>";
print "</body>";
print "</html>";

function display_table($connection, $table_name, $title, $columns) {
    print "<h2>$title</h2>";
    
    $columns_str = implode(", ", $columns);
    $sql = "SELECT $columns_str FROM $table_name";
    $result = pg_query($connection, $sql);
    
    if (!$result) {
        print "<p class='error'>Ошибка при получении данных из таблицы $table_name</p>";
        return;
    }
    
    $n = pg_num_rows($result);
    
    if ($n > 0) {
        print "<table>";
        print "<tr>";
        foreach ($columns as $column) {
            print "<th>" . ucfirst(str_replace("_", " ", $column)) . "</th>";
        }
        print "</tr>";
        
        for ($i = 0; $i < $n; $i++) {
            $row = pg_fetch_assoc($result);
            print "<tr>";
            foreach ($columns as $column) {
                $value = isset($row[$column]) ? htmlspecialchars($row[$column]) : 'NULL';
                print "<td>$value</td>";
            }
            print "</tr>";
        }
        
        print "</table>";
        print "<p class='count'>Всего записей: $n</p>";
    } else {
        print "<p>Таблица $table_name пуста</p>";
    }
}
?>
