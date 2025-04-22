<?php
class OrderModel
{
    public static function getAllOrders()
    {
        $con = getDBConnection();
        $sql = "SELECT * FROM orders";
        $result = pg_query($con, $sql);
        $orders = [];
        while ($row = pg_fetch_assoc($result)) {
            $orders[] = $row;
        }
        pg_close($con);
        return $orders;
    }

    public static function createOrder($connection, $data)
    {
        $sql = "INSERT INTO orders (
                    client_id, dispatcher_id, driver_id, vehicle_id, 
                    origin, destination, cargo_description, weight_kg, delivery_date
                ) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";

        return pg_query_params($connection, $sql, [
            $data['client_id'],
            $data['dispatcher_id'],
            $data['driver_id'],
            $data['vehicle_id'],
            $data['origin'],
            $data['destination'],
            $data['cargo_description'],
            $data['weight_kg'],
            $data['delivery_date']
        ]);
    }
}
?>