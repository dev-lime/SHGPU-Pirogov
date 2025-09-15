<?php
require_once __DIR__ . '/BaseModel.php';

class DispatcherModel extends BaseModel
{
	protected static $tableName = 'dispatchers';
	protected static $primaryKey = 'dispatcher_id';
}
?>