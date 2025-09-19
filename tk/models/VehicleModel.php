<?php
require_once __DIR__ . '/BaseModel.php';

class VehicleModel extends BaseModel
{
	protected static $tableName = 'vehicles';
	protected static $primaryKey = 'vehicle_id';

	public static function getAllWithDrivers()
	{
		$con = getDBConnection();
		$sql = "SELECT v.*, d.full_name as driver_name
                FROM vehicles v
                LEFT JOIN drivers d ON v.driver_id = d.driver_id
                ORDER BY v.vehicle_id";

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
}
?>