<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function getUserRole()
{
    return $_SESSION['role'] ?? null;
}

function hasPermission($permission)
{
    if (!isLoggedIn())
        return false;

    $permissions = $_SESSION['permissions'] ?? [];
    return in_array($permission, $permissions) || in_array('all', $permissions);
}

function requireAuth()
{
    if (!isLoggedIn()) {
        header("Location: /tk/login.php");
        exit;
    }
}

function requireRole($role)
{
    requireAuth();
    if (getUserRole() !== $role) {
        header("Location: /tk/index.php?error=access_denied");
        exit;
    }
}

function requirePermission($permission)
{
    requireAuth();
    if (!hasPermission($permission)) {
        header("Location: /tk/index.php?error=access_denied");
        exit;
    }
}
?>