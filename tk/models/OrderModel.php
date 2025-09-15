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
}
?>