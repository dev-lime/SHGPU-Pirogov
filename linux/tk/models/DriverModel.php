<?php
class DriverModel extends BaseModel {
    protected static $tableName = 'drivers';
    protected static $primaryKey = 'driver_id';
    
    public static function create($connection, $data) {
        $fields = [
            'full_name' => $data['full_name'],
            'license_number' => $data['license_number'],
            'phone' => $data['phone']
        ];
        return parent::create($connection, $data, $fields);
    }
}
?>
