<?php
require_once __DIR__ . '/BaseModel.php';

class ClientModel extends BaseModel
{
	protected static $tableName = 'clients';
	protected static $primaryKey = 'client_id';

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