<?php
function getDashboardStats($userId, $userRole)
{
    $con = getDBConnection();

    $stats = [
        'total_orders' => 0,
        'active_orders' => 0,
        'completed_orders' => 0,
        'total_clients' => 0,
        'recent_orders' => []
    ];

    try {
        // Получаем статистику в зависимости от роли
        if ($userRole === 'admin' || $userRole === 'dispatcher') {
            // Для администраторов и диспетчеров - вся статистика
            $stats['total_orders'] = (int) pg_fetch_result(pg_query($con, "SELECT COUNT(*) FROM orders"), 0);
            $stats['active_orders'] = (int) pg_fetch_result(pg_query(
                $con,
                "SELECT COUNT(*) FROM orders WHERE status NOT IN ('delivered', 'cancelled')"
            ), 0);
            $stats['completed_orders'] = (int) pg_fetch_result(pg_query(
                $con,
                "SELECT COUNT(*) FROM orders WHERE status = 'delivered'"
            ), 0);
            $stats['total_clients'] = (int) pg_fetch_result(pg_query(
                $con,
                "SELECT COUNT(*) FROM clients"
            ), 0);

            $recentSql = "SELECT o.*, c.full_name as client_name 
                         FROM orders o 
                         LEFT JOIN clients c ON o.client_id = c.client_id 
                         ORDER BY o.created_at DESC 
                         LIMIT 5";

        } elseif ($userRole === 'driver') {
            // Для водителей - только их заказы
            $stats['total_orders'] = (int) pg_fetch_result(pg_query_params(
                $con,
                "SELECT COUNT(*) FROM orders WHERE driver_id = $1",
                [$userId]
            ), 0);
            $stats['active_orders'] = (int) pg_fetch_result(pg_query_params(
                $con,
                "SELECT COUNT(*) FROM orders WHERE driver_id = $1 AND status NOT IN ('delivered', 'cancelled')",
                [$userId]
            ), 0);
            $stats['completed_orders'] = (int) pg_fetch_result(pg_query_params(
                $con,
                "SELECT COUNT(*) FROM orders WHERE driver_id = $1 AND status = 'delivered'",
                [$userId]
            ), 0);

            $recentSql = "SELECT o.*, c.full_name as client_name 
                         FROM orders o 
                         LEFT JOIN clients c ON o.client_id = c.client_id 
                         WHERE o.driver_id = $1 
                         ORDER BY o.created_at DESC 
                         LIMIT 5";

        } elseif ($userRole === 'client') {
            // Для клиентов - только их заказы
            $stats['total_orders'] = (int) pg_fetch_result(pg_query_params(
                $con,
                "SELECT COUNT(*) FROM orders WHERE client_id = $1",
                [$userId]
            ), 0);
            $stats['active_orders'] = (int) pg_fetch_result(pg_query_params(
                $con,
                "SELECT COUNT(*) FROM orders WHERE client_id = $1 AND status NOT IN ('delivered', 'cancelled')",
                [$userId]
            ), 0);
            $stats['completed_orders'] = (int) pg_fetch_result(pg_query_params(
                $con,
                "SELECT COUNT(*) FROM orders WHERE client_id = $1 AND status = 'delivered'",
                [$userId]
            ), 0);

            $recentSql = "SELECT o.*, c.full_name as client_name 
                         FROM orders o 
                         LEFT JOIN clients c ON o.client_id = c.client_id 
                         WHERE o.client_id = $1 
                         ORDER BY o.created_at DESC 
                         LIMIT 5";
        }

        // Получаем последние заказы
        if ($userRole === 'admin' || $userRole === 'dispatcher') {
            $result = pg_query($con, $recentSql);
        } else {
            $result = pg_query_params($con, $recentSql, [$userId]);
        }

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $stats['recent_orders'][] = $row;
            }
        }

    } catch (Exception $e) {
        error_log("Dashboard stats error: " . $e->getMessage());
    }

    return $stats;
}

function getStatusText($status)
{
    $statuses = [
        'new' => 'Новый',
        'picked_up' => 'Забран со склада',
        'in_transit' => 'В пути',
        'delivered' => 'Доставлен',
        'cancelled' => 'Отменён'
    ];

    return $statuses[$status] ?? $status;
}

// Функция для получения статусов заказов для фильтрации
function getOrderStatuses()
{
    return [
        'all' => 'Все заказы',
        'new' => 'Новые',
        'picked_up' => 'Забраны со склада',
        'in_transit' => 'В пути',
        'delivered' => 'Доставленные',
        'cancelled' => 'Отменённые'
    ];
}

// Функция для получения заказов с фильтрацией
function getFilteredOrders($filters = [])
{
    $con = getDBConnection();

    $whereConditions = [];
    $params = [];
    $paramCount = 1;

    // Базовая часть запроса
    $sql = "SELECT o.*, c.full_name as client_name, d.full_name as driver_name 
           FROM orders o 
           LEFT JOIN clients c ON o.client_id = c.client_id 
           LEFT JOIN drivers d ON o.driver_id = d.driver_id";

    // Добавляем условия фильтрации
    if (!empty($filters['status']) && $filters['status'] !== 'all') {
        $whereConditions[] = "o.status = $" . $paramCount++;
        $params[] = $filters['status'];
    }

    if (!empty($filters['client_id'])) {
        $whereConditions[] = "o.client_id = $" . $paramCount++;
        $params[] = $filters['client_id'];
    }

    if (!empty($filters['driver_id'])) {
        $whereConditions[] = "o.driver_id = $" . $paramCount++;
        $params[] = $filters['driver_id'];
    }

    if (!empty($filters['date_from'])) {
        $whereConditions[] = "o.created_at >= $" . $paramCount++;
        $params[] = $filters['date_from'];
    }

    if (!empty($filters['date_to'])) {
        $whereConditions[] = "o.created_at <= $" . $paramCount++;
        $params[] = $filters['date_to'];
    }

    // Добавляем WHERE если есть условия
    if (!empty($whereConditions)) {
        $sql .= " WHERE " . implode(" AND ", $whereConditions);
    }

    // Сортировка
    $sql .= " ORDER BY o.created_at DESC";

    // Лимит для пагинации
    if (!empty($filters['limit'])) {
        $sql .= " LIMIT $" . $paramCount++;
        $params[] = $filters['limit'];
    }

    if (!empty($filters['offset'])) {
        $sql .= " OFFSET $" . $paramCount++;
        $params[] = $filters['offset'];
    }

    // Выполняем запрос
    if (!empty($params)) {
        $result = pg_query_params($con, $sql, $params);
    } else {
        $result = pg_query($con, $sql);
    }

    $orders = [];
    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $orders[] = $row;
        }
    }

    return $orders;
}
?>