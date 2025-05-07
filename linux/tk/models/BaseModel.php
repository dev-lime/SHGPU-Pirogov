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
		return pg_query_params($connection, $sql, array_values($data));
	}
}
?>