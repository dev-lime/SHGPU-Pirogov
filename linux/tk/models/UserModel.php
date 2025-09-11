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
        return pg_fetch_assoc($result);
    }

    public static function verifyPassword($password, $hash)
    {
        // Добавим отладочную информацию
        error_log("Password: " . $password);
        error_log("Hash: " . $hash);
        error_log("Verification result: " . (password_verify($password, $hash) ? 'true' : 'false'));

        return password_verify($password, $hash);
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
?>