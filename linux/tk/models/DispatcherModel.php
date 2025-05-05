<?php
class DispatcherModel {
    public static function getAllDispatchers() {
        $con = getDBConnection();
        $sql = "SELECT * FROM dispatchers";
        $result = pg_query($con, $sql);
        $dispatchers = [];
        while ($row = pg_fetch_assoc($result)) {
            $dispatchers[] = $row;
        }
        pg_close($con);
        return $dispatchers;
    }

    public static function createDispatcher($connection, $data) {
        $sql = "INSERT INTO dispatchers (full_name, phone, email) 
                VALUES ($1, $2, $3)";
        
        return pg_query_params($connection, $sql, [
            $data['full_name'],
            $data['phone'],
            $data['email']
        ]);
    }
}
?>
