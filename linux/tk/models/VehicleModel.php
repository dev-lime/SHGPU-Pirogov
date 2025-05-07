<?php
require_once __DIR__ . '/BaseModel.php';

class VehicleModel extends BaseModel
{
	protected static $tableName = 'vehicles';
	protected static $primaryKey = 'vehicle_id';
}
?>