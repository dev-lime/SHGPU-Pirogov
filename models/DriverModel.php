<?php
class DriverModel
{
    public static function getAllDrivers()
    {
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

    public static function createDriver($connection, $data)
    {
        $sql = "INSERT INTO drivers (full_name, license_number, phone) 
                VALUES ($1, $2, $3)";

        return pg_query_params($connection, $sql, [
            $data['full_name'],
            $data['license_number'],
            $data['phone']
        ]);
    }
}
?>