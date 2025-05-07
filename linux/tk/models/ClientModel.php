<?php
require_once __DIR__ . '/BaseModel.php';

class ClientModel extends BaseModel
{
	protected static $tableName = 'clients';
	protected static $primaryKey = 'client_id';
}
?>