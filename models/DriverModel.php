<?php
class DriverModel {
    public static function getAllDrivers() {
        $con = getDBConnection();
        $sql = "SELECT * FROM drivers";
        $result = pg_query($con, $sql);
        $drivers = [];
        while ($row = pg_fetch_assoc($result)) {
            $drivers[] = $row;
        }
        pg_close($con);
        return $drivers;
    }
}
?>
