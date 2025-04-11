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
}
?>
