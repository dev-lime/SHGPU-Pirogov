<?php
abstract class BaseModel
{
	protected static $tableName;
	protected static $primaryKey;

	public static function getAll()
	{
		$con = getDBConnection();
		$sql = "SELECT * FROM " . static::$tableName;
		$result = pg_query($con, $sql);

		if (!$result) {
			error_log("Query failed: " . pg_last_error($con));
			return [];
		}

		$items = [];
		while ($row = pg_fetch_assoc($result)) {
			$items[] = $row;
		}
		pg_close($con);
		return $items;
	}

	public static function create($connection, $data)
	{
		$columns = implode(', ', array_keys($data));
		$placeholders = '$' . implode(', $', range(1, count($data)));

		$sql = "INSERT INTO " . static::$tableName . " ($columns) VALUES ($placeholders)";
		$result = pg_query_params($connection, $sql, array_values($data));

		if (!$result) {
			error_log("Create failed: " . pg_last_error($connection));
			return false;
		}

		return $result;
	}

	public static function delete($connection, $ids)
	{
		if (empty($ids)) {
			return false;
		}

		$placeholders = implode(',', array_fill(0, count($ids), '$' . implode(', $', range(1, count($ids)))));
		$sql = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . " IN ($placeholders)";
		$result = pg_query_params($connection, $sql, $ids);

		if (!$result) {
			error_log("Delete failed: " . pg_last_error($connection));
			return false;
		}

		return $result;
	}
}
?>