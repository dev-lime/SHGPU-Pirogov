<?php
class VehicleModel {
    public static function getAllVehicles() {
        $con = getDBConnection();
        $sql = "SELECT * FROM vehicles";
        $result = pg_query($con, $sql);
        $vehicles = [];
        while ($row = pg_fetch_assoc($result)) {
            $vehicles[] = $row;
        }
        pg_close($con);
        return $vehicles;
    }

    public static function createVehicle($connection, $data) {
        $sql = "INSERT INTO vehicles (plate_number, model, capacity_kg, status) 
                VALUES ($1, $2, $3, $4)";
        
        return pg_query_params($connection, $sql, [
            $data['plate_number'],
            $data['model'],
            $data['capacity_kg'],
            $data['status']
        ]);
    }
}
?>
