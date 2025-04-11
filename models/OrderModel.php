<?php
class OrderModel {
    public static function getAllOrders() {
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
}
?>
