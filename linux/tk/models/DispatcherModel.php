<?php
class DispatcherModel extends BaseModel {
    protected static $tableName = 'dispatchers';
    protected static $primaryKey = 'dispatcher_id';
    
    public static function create($connection, $data) {
        $fields = [
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'email' => $data['email']
        ];
        return parent::create($connection, $data, $fields);
    }
}
?>
