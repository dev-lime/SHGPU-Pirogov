<?php
require_once __DIR__ . '/BaseModel.php';

class DriverModel extends BaseModel
{
	protected static $tableName = 'drivers';
	protected static $primaryKey = 'driver_id';
}
?>