<?php
require_once __DIR__ . '/BaseModel.php';

class OrderModel extends BaseModel
{
	protected static $tableName = 'orders';
	protected static $primaryKey = 'order_id';
}
?>