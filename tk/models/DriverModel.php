<?php
require_once __DIR__ . '/BaseModel.php';

class DriverModel extends BaseModel
{
	protected static $tableName = 'drivers';
	protected static $primaryKey = 'driver_id';

	public static function getAllWithVehicles()
	{
		$con = getDBConnection();
		$sql = "SELECT d.*, v.plate_number, v.model
                FROM drivers d
                LEFT JOIN vehicles v ON d.driver_id = v.driver_id
                ORDER BY d.driver_id";

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

	public static function getById($connection, $id)
	{
		$sql = "SELECT * FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = $1";
		$result = pg_query_params($connection, $sql, [$id]);

		if (!$result) {
			return false;
		}

		return pg_fetch_assoc($result);
	}

	// Метод для получения заказов водителя
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
}
?>