<?php
class ClientModel {
    public static function getAllClients() {
        $con = getDBConnection();
        $sql = "SELECT * FROM clients";
        $result = pg_query($con, $sql);
        $clients = [];
        while ($row = pg_fetch_assoc($result)) {
            $clients[] = $row;
        }
        pg_close($con);
        return $clients;
    }

    public static function createClient($connection, $data) {
        $sql = "INSERT INTO clients (full_name, phone, email, company_name) 
                VALUES ($1, $2, $3, $4)";
        
        $result = pg_query_params($connection, $sql, [
            $data['full_name'],
            $data['phone'],
            $data['email'],
            $data['company_name']
        ]);
        
        return $result;
    }
}
?>
