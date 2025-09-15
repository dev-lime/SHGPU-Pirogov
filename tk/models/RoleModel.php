<?php
require_once __DIR__ . '/BaseModel.php';

class RoleModel extends BaseModel
{
    protected static $tableName = 'roles';
    protected static $primaryKey = 'role_id';
}
?>