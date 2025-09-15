<?php
require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel
{
    protected static $tableName = 'users';
    protected static $primaryKey = 'user_id';

    public static function findByUsername($username)
    {
        $con = getDBConnection();
        $sql = "SELECT u.*, r.role_name, r.permissions 
            FROM users u 
            LEFT JOIN roles r ON u.role_id = r.role_id 
            WHERE u.username = $1";

        $result = pg_query_params($con, $sql, [$username]);

        if (!$result) {
            error_log("Query failed: " . pg_last_error($con));
            return false;
        }

        $user = pg_fetch_assoc($result);

        if ($user && isset($user['permissions'])) {
            $user['permissions'] = trim($user['permissions'], '{}');
            $user['permissions'] = explode(',', $user['permissions']);
        }

        return $user;
    }

    public static function verifyPassword($password, $hash)
    {
        $cleanHash = trim($hash, '{}');

        return password_verify($password, $cleanHash);
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
?>