<?php
require_once __DIR__ . '/BaseModel.php';

class OrderModel extends BaseModel
{
	protected static $tableName = 'orders';
	protected static $primaryKey = 'order_id';

	public static function updateStatus($connection, $orderId, $status)
	{
		if ($status === 'delivered') {
			$sql = "UPDATE " . static::$tableName . "
                    SET status = $1, delivery_date = NOW()
                    WHERE " . static::$primaryKey . " = $2";
		} else {
			$sql = "UPDATE " . static::$tableName . "
                    SET status = $1
                    WHERE " . static::$primaryKey . " = $2";
		}
		return pg_query_params($connection, $sql, [$status, $orderId]);
	}

	public static function getAllWithDetails()
	{
		$con = getDBConnection();
		$sql = "SELECT o.*, c.full_name as client_name, d.full_name as driver_name
                FROM orders o
                LEFT JOIN clients c ON o.client_id = c.client_id
                LEFT JOIN drivers d ON o.driver_id = d.driver_id
                ORDER BY o.created_at DESC";

		$result = pg_query($con, $sql);

		if (!$result) {
			error_log("Query failed: " . pg_last_error($con));
			pg_close($con);
			return [];
		}

		$items = [];
		while ($row = pg_fetch_assoc($result)) {
			$items[] = $row;
		}

		pg_free_result($result);
		pg_close($con);
		return $items;
	}

	public static function getDriverOrders($driverId)
	{
		$con = getDBConnection();
		$sql = "SELECT o.*, c.full_name as client_name
                FROM orders o
                LEFT JOIN clients c ON o.client_id = c.client_id
                WHERE o.driver_id = $1
                ORDER BY o.created_at DESC";

		$result = pg_query_params($con, $sql, [$driverId]);

		if (!$result) {
			error_log("Query failed: " . pg_last_error($con));
			pg_close($con);
			return [];
		}

		$items = [];
		while ($row = pg_fetch_assoc($result)) {
			$items[] = $row;
		}

		pg_free_result($result);
		pg_close($con);
		return $items;
	}

	public static function getClientOrders($clientId)
	{
		$con = getDBConnection();
		$sql = "SELECT o.*, c.full_name as client_name
                FROM orders o
                LEFT JOIN clients c ON o.client_id = c.client_id
                WHERE o.client_id = $1
                ORDER BY o.created_at DESC";

		$result = pg_query_params($con, $sql, [$clientId]);

		if (!$result) {
			error_log("Query failed: " . pg_last_error($con));
			pg_close($con);
			return [];
		}

		$items = [];
		while ($row = pg_fetch_assoc($result)) {
			$items[] = $row;
		}

		pg_free_result($result);
		pg_close($con);
		return $items;
	}

	public static function getById($connection, $id)
	{
		$sql = "SELECT o.*, c.full_name as client_name, c.phone as client_phone, 
                       c.email as client_email, d.full_name as driver_name,
                       v.plate_number, v.model as vehicle_model
                FROM orders o
                LEFT JOIN clients c ON o.client_id = c.client_id
                LEFT JOIN drivers d ON o.driver_id = d.driver_id
                LEFT JOIN vehicles v ON o.vehicle_id = v.vehicle_id
                WHERE o.order_id = $1";

		$result = pg_query_params($connection, $sql, [$id]);

		if (!$result || pg_num_rows($result) === 0) {
			return false;
		}

		return pg_fetch_assoc($result);
	}
}
?>