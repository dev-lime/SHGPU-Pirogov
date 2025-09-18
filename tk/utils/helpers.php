<?php
/**
 * Вспомогательные функции
 */

/**
 * Форматирует число в денежный формат
 */
function formatCurrency($amount, $currency = '₽')
{
    return number_format($amount, 2, ',', ' ') . ' ' . $currency;
}

/**
 * Форматирует дату
 */
function formatDate($dateString, $format = 'd.m.Y')
{
    if (!$dateString)
        return '-';
    return date($format, strtotime($dateString));
}

/**
 * Форматирует дату и время
 */
function formatDateTime($dateString, $format = 'd.m.Y H:i')
{
    if (!$dateString)
        return '-';
    return date($format, strtotime($dateString));
}

/**
 * Получает человекочитаемое название статуса
 */
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

/**
 * Проверяет email на валидность
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Генерирует случайный пароль
 */
function generatePassword($length = 12)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
    $password = '';
    $charsLength = strlen($chars) - 1;

    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $charsLength)];
    }

    return $password;
}

/**
 * Логирование действий
 */
function logAction($action, $details = null, $userId = null)
{
    $con = getDBConnection();
    $userId = $userId ?? $_SESSION['user_id'] ?? null;

    $sql = "INSERT INTO action_logs (user_id, action, details, ip_address, user_agent) 
            VALUES ($1, $2, $3, $4, $5)";

    $details = $details ? json_encode($details) : null;
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

    pg_query_params($con, $sql, [$userId, $action, $details, $ipAddress, $userAgent]);
}

/**
 * Получает настройки из базы данных
 */
function getSetting($key, $default = null)
{
    $con = getDBConnection();
    $sql = "SELECT value FROM settings WHERE key = $1";
    $result = pg_query_params($con, $sql, [$key]);

    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    }

    return $default;
}

/**
 * Устанавливает настройку в базу данных
 */
function setSetting($key, $value)
{
    $con = getDBConnection();
    $sql = "INSERT INTO settings (key, value) VALUES ($1, $2)
            ON CONFLICT (key) DO UPDATE SET value = EXCLUDED.value";

    return pg_query_params($con, $sql, [$key, $value]);
}

/**
 * Редирект с сообщением
 */
function redirectWithMessage($url, $type, $message)
{
    header("Location: $url?$type=" . urlencode($message));
    exit;
}

/**
 * Получает текущий URL
 */
function getCurrentUrl()
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
        "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

/**
 * Экранирует HTML специальные символы
 */
function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>