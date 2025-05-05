<?php
class BaseModel {
    protected static $tableName;
    protected static $primaryKey;
    
    public static function getAll() {
        $con = getDBConnection();
        $sql = "SELECT * FROM " . static::$tableName;
        $result = pg_query($con, $sql);
        $items = [];
        while ($row = pg_fetch_assoc($result)) {
            $items[] = $row;
        }
        pg_close($con);
        return $items;
    }
    
    protected static function create($connection, $data, $fields) {
        $columns = implode(', ', array_keys($fields));
        $placeholders = '$' . implode(', $', range(1, count($fields)));
        
        $sql = "INSERT INTO " . static::$tableName . " ($columns) VALUES ($placeholders)";
        return pg_query_params($connection, $sql, array_values($fields));
    }
}
?>
