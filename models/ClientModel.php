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
}
?>
